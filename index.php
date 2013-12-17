<?php

date_default_timezone_set('Australia/Sydney');
// Autoload composer packages
require './vendor/autoload.php';

// Load slim framework
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json');
/* $app->response()->header('Access-Control-Allow-Origin', '*'); */
/* $app->response()->header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); */

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') 
{
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && (
        $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET' ||
        $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST' ||
        $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'DELETE' ||
        $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'PUT' )) 
    {
        $app->response->header('Access-Control-Allow-Origin: *');
        $app->response->header("Access-Control-Allow-Credentials: true");
        $app->response->header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        $app->response->header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
        $app->response->header('Access-Control-Max-Age: 86400');
    }
    exit;
}

// SETUP ENVIRONMENT
define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
        break;

        case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

// Config database
require './config/database.php';

// Load routers
require 'routes.php';

$app->run();

