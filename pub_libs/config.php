<?php

/**
 * The purpose of this central config file is configuring all examples
 * in one place with minimal work for your working environment
 * Just configure all the items in this config according to your environment
 * and rename the file to config.php
 *
 * PHP Version 5
 *
 * @file     config.php
 * @category Authentication
 * @package  PhpCAS
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link     https://wiki.jasig.org/display/CASC/phpCAS
 */
$phpcas_path = '';

///////////////////////////////////////
// Basic Config of the phpCAS client //
///////////////////////////////////////
// Full Hostname of your CAS Server
// $cas_host = '192.168.30.131:8443';
//$cas_host = '103.40.94.39:8443';
$cas_host = 'sso.basarnas.go.id';

// Context of the CAS Server
$cas_context = '/cas';

// Port of your CAS server. Normally for a https server it's 443
//$cas_port = 50443;
$cas_port = 8443;

// Path to the ca chain that issued the cas server certificate
$cas_server_ca_cert_path = '';

?>
