<?php
ob_start(); //output buffering is turned on

//Paths to the folder structure as constants
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define('PUBLIC_PATH', PROJECT_PATH.'/public');
define("SHARED_PATH", PRIVATE_PATH.'/shared');


//URL constants to use for links inside the site
//Works on all serves wihtout any changes

$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define('WWW_ROOT', $doc_root);

require_once ('functions.php');
require_once ('validation.php');
require_once ('database.php');

$db = db_connect();
