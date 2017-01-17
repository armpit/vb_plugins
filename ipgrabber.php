<?php
/**
 * Display some useless info in the footer. xD
 * Requires phpBrowsCap - https://github.com/garetjax/phpbrowscap
 *
 * Plugin needs to run from: global_bootstrap_init
 */

$ip = $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];

require 'vendor/autoload.php';
use phpbrowscap\Browscap;

$browscap = new Browscap('tmp');
$browscap->doAutoUpdate = false;
$b = $browscap->getBrowser();

// Set browser and platform
isset($b->Parent) ? $browser = $b->Parent : $browser = 'Unknown Browser';
isset($b->Platform) ? $platform = $b->Platform : $platform = 'Unknown Operating System';

// Handle 'unknown' returned as browser or platform
if ($browser == 'unknown') { $browser = 'Unknown Browser'; }
if ($platform == 'unknown') { $platform = 'Unknown Operating System'; }

// Get GeoIP data
if (function_exists(geoip_record_by_name)) {
    $g = geoip_record_by_name($_SERVER['REMOTE_ADDR']);

    isset($g['city']) ? $city = $g['city'] : $city = '';
    isset($g['region']) ? $region = $g['region'] : $region = '';
    isset($g['country_code']) ? $ccode = $g['country_code'] : $ccode = '';
    isset($g['country_name']) ? $country = $g['country_name'] : $country = '';

	// Convert region code to full name
    if (isset($region) && $region != '') {
	$region = geoip_region_name_by_code($ccode, $region);
    } else {
	$region = 'unknown';
    }

	// Build final string
    $gstring = '';
    if (!empty($city)) { $gstring = $gstring . $city . ",&nbsp;"; }
    if (!empty($region)) { $gstring = $gstring . $region . ",&nbsp;"; }
    if (!empty($country)) { $gstring = $gstring . $country; }
}

// Register vars in template
vB_Template::PreRegister(
    'footer',
    array(
    'AIG_ip_address' => $ip,
    'AIG_browser'    => $browser,
    'AIG_platform'   => $platform,
    'AIG_geoip'      => $gstring
    )
);
