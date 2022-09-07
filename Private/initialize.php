<?php

define("PRIVATE_PATH", dirname(__FILE__));
// define("PROJECT_PATH", dirname(PRIVATE_PATH));

// To run locally,do this
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/pasteboard') + 11;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

// To run in container where project is directly in /var/www/html/, use this
// define("WWW_ROOT", '');
require_once('functions.php');
require_once('database.php');
require_once('sql_queries.php');

$db = db_connect();
