<?php
/**
 * Custom browser check
 *
 * Uses https://github.com/cbschuld/Browser.php
 */

function b5f_browser_check($what) {
    global $browser, $browver;
	switch ($what) {
        case 'version':
            return $browver;
		break;
        case 'ie':
			if ($browser==Browser::BROWSER_IE) return true;
			else return false;
		break;
        case 'ff':
			if ($browser==Browser::BROWSER_FIREFOX) return true;
			else return false;
		break;
		case 'mobile':
			if ($browser==Browser::BROWSER_MSNBOT || $browser==Browser::BROWSER_MSN || $browser==Browser::BROWSER_NOKIA || $browser==Browser::BROWSER_NOKIA_S60 || $browser==Browser::BROWSER_BLACKBERRY || $browser==Browser::BROWSER_W3CVALIDATOR || $browser==Browser::BROWSER_GOOGLEBOT || $browser==Browser::BROWSER_ANDROID || $browser==Browser::BROWSER_IPAD || $browser==Browser::BROWSER_IPOD || $browser==Browser::BROWSER_IPHONE) return true;
			else return false;
		break;
		default:
			return false;
		break;
    }
}

require_once('Browser.php');
$browser_check = new Browser();
$browser = $browser_check->getBrowser();
$browver = $browser_check->getVersion();
