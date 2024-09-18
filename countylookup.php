<?php

require_once 'countylookup.civix.php';

function countylookup_civicrm_geocoderFormat($geoProvider, &$values, $xml) {
  if ($geoProvider !== 'Google') {
    exit;
  }
  // When running the scheduled job you may get no results.
  if (!$xml->result) {
    return;
  }
  $countyName = NULL;
  $stateName = NULL;
  foreach ($xml->result->address_component as $test) {
    $type = (string) $test->type[0];
    if ($type == 'administrative_area_level_1') {
      $stateName = (string) $test->long_name;
    }
    if ($type == 'administrative_area_level_2') {
      $countyName = (string) $test->long_name;
    }
  }
  if (!$countyName || !$stateName) {
    return;
  }

  // Take off the word "County".
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

function countylookup_civicrm_check(&$messages) {
  countylookup_googleIsProvider($messages);
  countylookup_countyIsEnabled($messages);
}

function countylookup_googleIsProvider(&$messages) {
  $geoProvider = civicrm_api3('Setting', 'getvalue', array(
    'name' => "geoProvider",
  ));
  if ($geoProvider !== 'Google') {
    $messages[] = new CRM_Utils_Check_Message(
      'countylookup_geoProvider',
      ts('You have enabled the County Lookup extension, but your geoprovider is not Google.'),
      ts('Wrong geoProvider'),
      \Psr\Log\LogLevel::WARNING,
      'fa-globe'
    );
  }
}
function countylookup_countyIsEnabled(&$messages) {
  // Get the value of "county" from the option values table.
  $id = civicrm_api3('OptionValue', 'getsingle', array(
    'return' => array("value"),
    'option_group_id' => "address_options",
    'name' => "county",
  ));
  // Get the address_options.
  $result = civicrm_api3('Setting', 'get', array(
    'sequential' => 1,
    'return' => array("address_options"),
  ));
  // Is "county" set in address_options?
  $countyEnabled = in_array($id['value'], $result['values'][0]['address_options']);
  if (!$countyEnabled) {
    $messages[] = new CRM_Utils_Check_Message(
      'countylookup_countyEnabled',
      ts('You have enabled the County Lookup extension, but you have not enabled the "County" field in Administer menu » Localization » Address Settings.'),
      ts('County field is not enabled'),
      \Psr\Log\LogLevel::WARNING,
      'fa-globe'
    );
  }
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
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function countylookup_civicrm_install() {
  _countylookup_civix_civicrm_install();
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
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *

*/
