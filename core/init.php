<?php 
date_default_timezone_set('Asia/Manila');
session_start();
ob_start();
// header("Content-Type: text/html; charset=ISO-8859-1");

require 'paths.php';
require HELPERS.'helpers.php';
require HELPERS.'functions.php';
require DR.DS.'miaa'.DS.'vendor'.DS.'autoload.php'; 

$GLOBALS['config'] = array(
	'mysql' => [
		'host' => '127.0.0.1', 
		'username' => 'root',
		'password' => 'root',
		'genderdb' => 'genderdb',
		'workforcedb' => 'workforcedb',
		'systemsdb' => 'systems',
		'globalrefdb' => 'global_ref'
	]
);
