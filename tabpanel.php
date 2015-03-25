<?php

require_once 'tabpanel.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function tabpanel_civicrm_config(&$config) {
  _tabpanel_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function tabpanel_civicrm_xmlMenu(&$files) {
  _tabpanel_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function tabpanel_civicrm_install() {
  return _tabpanel_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function tabpanel_civicrm_uninstall() {
  return _tabpanel_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function tabpanel_civicrm_enable() {
  return _tabpanel_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function tabpanel_civicrm_disable() {
  return _tabpanel_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function tabpanel_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _tabpanel_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function tabpanel_civicrm_managed(&$entities) {
  return _tabpanel_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function tabpanel_civicrm_caseTypes(&$caseTypes) {
  _tabpanel_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function tabpanel_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _tabpanel_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implementation of hook_civicrm_tabs
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tabs
 */
function tabpanel_civicrm_tabs( &$tabs, $contactID ) {

  // don't need tabpanel tabs for non individual contacts - is it true ? at least remove from non standard individual (Media, Initiatives)
  $params = array(
    'contact_id' => $contactID,
    'return' => 'contact_type',
  );
  $type = civicrm_api3('Contact', 'getvalue', $params);


  // remove tabpanel related custom group tabs
  $cgnames = CRM_Core_BAO_Setting::getItem('coop.symbiotic.tabpanel', 'tabpanel_custom_groups_name');
  $cgnames = json_decode($cgnames, true);
  foreach ($tabs as $i => $tab) {
    if (in_array($tab['id'], $cgnames)) {
      unset($tabs[$i]);
    }
  }

  // add tab for each tabpanel
  $panels = CRM_Core_BAO_Setting::getItem('coop.symbiotic.tabpanel', 'tabpanel_panels');
  $panels = json_decode($panels, true);
  watchdog('debug', print_r($panels, 1));
  foreach ($panels as $id => $panel) {

    $url = CRM_Utils_System::url( 'civicrm/contact/view/tabpanel',
                                  "reset=1&snippet=1&force=1&cid=$contactID&panel=$id" );

    $tabs[] = array( 'id'    => 'tabpanel-' . $id,
                        'url'   => $url,
                        'title' => $panel['title'],  // FIXME: need to add i18n support here
                        'weight' => isset($panel['weight']) ? $panel['weight'] : 200,
                        'class' => 'livePage' );
     
  }

  // add css for content in the tab panels
  CRM_Core_Resources::singleton()->addStyleFile('coop.symbiotic.tabpanel', 'tabpanel.css');


}

