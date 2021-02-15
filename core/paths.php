<?php

function site_url() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    
    return $protocol.$domainName;
}

defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);
define('HOST', site_url().DS); 
define('SITE_URL', HOST.'miaa'.DS);
define('MODULE', HOST.'miaa'.DS.'module'.DS); 
define('MODULE_URL', SITE_URL.'module'.DS.'gender'.DS);
define('DR',$_SERVER['DOCUMENT_ROOT']);
define('SITE_ROOT',DS.'miaa'.DS.'module'.DS.'gender'.DS);
define('INCLUDES',DR.SITE_ROOT.'includes'.DS);
define('HELPERS',DR.SITE_ROOT.'helpers'.DS);
define('ASSETS',DS.'miaa'.DS.'assets'.DS);
define('CSS',ASSETS.'css'.DS);
define('JS',ASSETS.'js'.DS);
define('IMAGES',ASSETS.'images'.DS);
define('DOCUMENTS', ASSETS.'documents'.DS);
define('UPLOADS', ASSETS.'uploads'.DS);