<?php

require_once 'countylookup.civix.php';

function countylookup_civicrm_geocoderFormat($geoProvider, &$values, $xml) {
  if ($geoProvider !== 'Google') {
    exit;
  }
  foreach ($xml->result->address_component as $test) {
    $type = (string) $test->type[0];
    if ($type == 'administrative_area_level_1') {
      $stateName = (string) $test->long_name;
    }
    if ($type == 'administrative_area_level_2') {
      $countyName = (string) $test->long_name;
    }
  }
  // Take off the work "County".
  $countyName = trim(str_replace('County', '', $countyName));

  // For < 4.7 compatibility, do 2 API calls instead of a join.
  // FIXME: We no longer need to support < 4.7.
  $result = civicrm_api3('StateProvince', 'get', array(
    'return' => array("id"),
    'name' => $stateName,
  ));
  $state_province_id = $result['id'];
  $result = civicrm_api3('County', 'get', array(
    'sequential' => 1,
    'state_province_id' => $state_province_id,
    'name' => $countyName,
  ));
  $countyId = $result['id'];
  $values['county_id'] = $countyId;
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function countylookup_civicrm_config(&$config) {
  _countylookup_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function countylookup_civicrm_xmlMenu(&$files) {
  _countylookup_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function countylookup_civicrm_install() {
  _countylookup_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function countylookup_civicrm_uninstall() {
  _countylookup_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function countylookup_civicrm_enable() {
  _countylookup_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function countylookup_civicrm_disable() {
  _countylookup_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function countylookup_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _countylookup_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function countylookup_civicrm_managed(&$entities) {
  _countylookup_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function countylookup_civicrm_caseTypes(&$caseTypes) {
  _countylookup_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function countylookup_civicrm_angularModules(&$angularModules) {
_countylookup_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function countylookup_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _countylookup_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function countylookup_civicrm_preProcess($formName, &$form) {

}

*/
