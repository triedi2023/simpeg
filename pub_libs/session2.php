<?php
/**
 * Example that uses the CAS gateway feature
 *
 * PHP Version 5
 *
 * @file     example_gateway.php
 * @category Authentication
 * @package  PhpCAS
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link     https://wiki.jasig.org/display/CASC/phpCAS
 */

// Load the settings from the central config file
require_once __DIR__ .'/config.php';
// Load the CAS lib
require_once __DIR__ .'/vendor/phpCAS/CAS.php';
// Enable debugging
phpCAS::setDebug();
// Enable verbose error messages. Disable in production!
phpCAS::setVerbose(false);
// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context,false);
// For production use set the CA certificate that is the issuer of the cert
// on the CAS server and uncomment the line below
// phpCAS::setCasServerCACert($cas_server_ca_cert_path);
// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
phpCAS::setNoCasServerValidation();

//if (isset($_REQUEST['logout'])) {
    //phpCAS::logout();
	//phpCAS::logoutWithRedirectService("http://" . $_SERVER['SERVER_NAME'].""); 
	
	/* $nameserver = $_REQUEST['nameserver'];
	phpCAS::logoutWithRedirectService($nameserver);  */
//}
//if (isset($_REQUEST['login'])) {
  //  phpCAS::forceAuthentication();
//}

// check CAS authentication
//$auth = phpCAS::checkAuthentication();
phpCAS::forceAuthentication();

// Require the required files.
require 'vendor/SSO/SSO.php'; 

// Authenticate the user

$auth = SSO\SSO::authenticate();

// At this point, the authentication has succeeded.
// This shows how to get the user details.
$user = SSO\SSO::getUser();
//$destroy=SSO\SSO::logout($cas_host."/cas/logout");

$sess = $user;

$tSessionexp = $sess->tSessionexp;
$sessionid = $sess->sessionid;
$userid = $sess->username;

$serverName = "http://".$_SERVER['SERVER_NAME'];

$timoutWarning = $tSessionexp * 60 * 1000;
$timoutNow = $timoutWarning + 1000;
?>