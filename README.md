# coop.palantetech.countylookup

This is a plug-and-play extension to add county lookups to CiviCRM's geocoding.

Caveats:
* This relies on a hook that isn't yet part of core as of this writing -
  CRM-19298.
* It's tested for the U.S. only - though it should work for whatever the
  equivalent of county/parish/etc. is in your part of the world.
* It works with Google geocoding only.
