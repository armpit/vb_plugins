# VBulletin Plugins #

----------

### ipgrabber.php ###

Get users ip, browser, os and geoip information if the php-geoip module is available. Requires browscap-php which can be installed from the cli: 

```bash
$ composer require browscap/browscap-php
```

The plugin needs to run from 'global_bootstrap_init' and registers the following strings with the footer template:

- $AIG_ip_address (eg: 211.222.233.244)
- $AIG_browser    (eg: Firefox 45.0)
- $AIG_platform   (eg: Linux)
- $AIG_geoip      (eg: Brisbane, Qld, Australia)
