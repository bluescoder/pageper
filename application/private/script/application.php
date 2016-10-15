<?php 

/** 
 * Main script for admin functionality. Contains constants, core functions, references to 
 * other scripts, etc...
 */

// Base directories
define ('APPLICATION_PRIVATE', dirname(__FILE__) . '/../');
define ('APPLICATION_PUBLIC', dirname(__FILE__) . '/../public/');
define ('DATA_PRIVATE', dirname(__FILE__) . '/../../../data/private/');
define ('DATA_PUBLIC', dirname(__FILE__) . '/../../../data/public/');
define ('APPLICATION_PRIVATE_VIEW_TEMPLATES', APPLICATION_PRIVATE . 'view/');

define ('MODEL_FOLDER', APPLICATION_PRIVATE . 'script/model/');
define ('PRIVATE_PLUGIN_FOLDER', APPLICATION_PRIVATE. 'plugin/');
define ('PUBLIC_PLUGIN_FOLDER', DATA_PRIVATE. 'plugin/');


// Initialize request state
require_once 'configuration.php';
require_once 'model.php';
require_once 'action.php';
require_once 'session.php';
require_once 'database.php';
require_once 'language.php';
require_once 'installation.php';
require_once 'users.php';
require_once 'cypher.php';
require_once 'plugins.php';
require_once 'resources.php';






?>