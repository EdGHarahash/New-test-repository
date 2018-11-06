<?php
/**
 * Initializing of framework
 */

// For authorization etc
session_start();

// Main constants
define('CORE_PATH', realpath(__DIR__));
define('SITE_PATH', realpath(CORE_PATH.'/../site'));
define('PUBLIC_PATH', realpath(CORE_PATH.'/../../web'));
define('VENDOR_PATH', realpath(CORE_PATH.'/../../vendor'));

// Defaults
define('MVC_DEFAULT_CONTROLLER', 'User'); // Default request will be /main/index
define('MVC_DEFAULT_ACTION', 'list'); // Default request will be /main/index

// Include libraries and framework parts
require VENDOR_PATH.'/autoload.php';
use App\Service;
//require_once SITE_PATH.'/controllers/MainController.php';
// require_once CORE_PATH.'/common.func.php';
//require_once CORE_PATH.'/db/db.interface.php';
//require_once CORE_PATH.'/db/db.func.php';
//require_once SITE_PATH.'/User.model.php';
