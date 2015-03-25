<?php

require_once 'CRM/Core/Page.php';
require_once 'CRM/Contact/Page/View/CustomData.php';

class CRM_Tabpanel_Page_Tabpanel extends CRM_Core_Page {

   /**
   * This function is the main function that is called when the page loads,
   * it decides the which action has to be taken for the page.
   *
   * return null
   * @access public
   */
  function run() {
    $this->preProcess();

    $this->setContext();

    // displaying info
    $this->browse();

    return parent::run();
  }

  function preProcess() {
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this);
    $this->_contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
    $this->_panelId = CRM_Utils_Request::retrieve('panel', 'Positive', $this, TRUE);
    $this->assign('contactId', $this->_contactId);
    $this->assign('panelId', $this->_panelId);

    // get panel infos
    $settings = CRM_Core_BAO_Setting::getItem('coop.symbiotic.tabpanel', 'tabpanel_custom_groups');
    $settings = json_decode($settings, true);
    $this->_customGroups = $settings[$this->_panelId]; 

    $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this, FALSE, 'browse');
    $this->assign('action', $this->_action);

    // check logged in url permission
    CRM_Contact_Page_View::checkUserPermission($this);

    // set page title
    CRM_Contact_Page_View::setTitle($this->_contactId);

  }

  function setContext() {
    // to refresh the page
    $url = CRM_Utils_System::url('civicrm/contact/view', "action=browse&selectedChild=tabpanel&reset=1&cid={$this->_contactId}&panel={$this->_panelId}");
    $session = CRM_Core_Session::singleton();
    $session->pushUserContext($url);
  }

  /**
   * This function is called when action is browse
   *
   * return null
   * @access public
   */
  function browse() {
    // prepare the tab panel
    $ids = $this->_customGroups;

    $cgcontent = array();
    foreach ($ids as $cgid) {
      $page = new CRM_Contact_Page_View_CustomData();
      $_REQUEST['gid'] = $cgid;
      $page->_embedded = 1;
      $page->run();

      // manually call template for each custom group page
      $pageTemplateFile = $page->getHookedTemplateFileName();
      self::$_template->assign('tplFile', $pageTemplateFile);

      // infos to be sent to the template file
      $cgcontent[$cgid] = array(
        'content' => self::$_template->fetch('CRM/common/snippet.tpl'),
      );
    }

    $this->assign('cgcontent', $cgcontent);

  }

}
