<?php

civicrm_initialize();

// TODO: create an admin UI for this

$panels = array(
  1 => array(
    'id' => 1,
    'title' => 'Profiling',
    'weight' => 200,
  ),
  2 => array(
    'id' => 2,
    'title' => 'Fundraising',
    'weight' => 100,
  )
);

$customgroups = array(
  '1' => array(18, 16, 26, 27),
  '2' => array(28, 29, 30),
);

// computed from $customgroups
$customgroupnames = array();
foreach ($customgroups as $pid => $ids) {
  foreach ($ids as $id) {
    $customgroupnames[] = 'custom_' . $id;
  }
}

// save all in db
CRM_Core_BAO_Setting::setItem(json_encode($customgroupnames), 'coop.symbiotic.tabpanel', 'tabpanel_custom_groups_name');
CRM_Core_BAO_Setting::setItem(json_encode($panels), 'coop.symbiotic.tabpanel', 'tabpanel_panels');
CRM_Core_BAO_Setting::setItem(json_encode($customgroups), 'coop.symbiotic.tabpanel', 'tabpanel_custom_groups');


