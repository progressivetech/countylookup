# coop.palantetech.countylookup

This extension causes the "county" field on addresses to automatically be populated when an address is created or updated.

Note that the [Geofill extension](https://github.com/ginkgostreet/com.ginkgostreet.geofill) from the folks at Ginkgo Street Labs does everything this extension does and more!  It takes a bit more setup though.

Setup:
* You must have the "county" field enabled in **Administer menu » Localization
  » Address Settings**.
* You must have your geocoding provider set (to Google) in **Administer menu »
  System Settings » Mapping and Geocoding**.

Caveats:
* This extension requires CiviCRM 4.7.7 or higher.
* It requires CiviCRM 4.7.20 or higher to work on batch geocoding (i.e. through Scheduled Jobs) without 
* It's tested for the U.S. only - though it should work for whatever the
  equivalent of county/parish/etc. is in your part of the world.
* It works with Google geocoding only at this time, patches welcome!
