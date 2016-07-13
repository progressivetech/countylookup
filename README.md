# coop.palantetech.countylookup

This extension causes the "county" field on addresses to automatically be populated when an address is created or updated.

Setup:
* You must have the "county" field enabled in **Administer menu » Localization
  » Address Settings**.
* You must have your geocoding provider set (to Google) in **Administer menu »
  System Settings » Mapping and Geocoding**.

Caveats:
* This extension requires CiviCRM 4.7.7 or higher.
* It's tested for the U.S. only - though it should work for whatever the
  equivalent of county/parish/etc. is in your part of the world.
* It works with Google geocoding only at this time, patches welcome!
* This extension works when a single contact is geocoded (e.g. an address is created/updated/imported).  It does NOT work with the geocoding scheduled job without the following change to CiviCRM core:

```diff
--- a/sites/all/modules/contrib/civicrm/CRM/Utils/Address/BatchUpdate.php
+++ b/sites/all/modules/contrib/civicrm/CRM/Utils/Address/BatchUpdate.php
@@ -215,6 +215,7 @@ class CRM_Utils_Address_BatchUpdate {
           $totalGeocoded++;
           $addressParams['geo_code_1'] = $params['geo_code_1'];
           $addressParams['geo_code_2'] = $params['geo_code_2'];
+          $addressParams['county_id'] = $params['county_id'];
           $addressParams['postal_code'] = $params['postal_code'];
           $addressParams['postal_code_suffix'] = CRM_Utils_Array::value('postal_code_suffix', $params);
         }
```
