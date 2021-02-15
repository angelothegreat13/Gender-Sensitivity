<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;

use Gender\Classes\References\Pds\PdsMain;

$pds = new PdsMain;

$unique = true;

if (Input::get('email')) {
    $unique = $pds->inputIsUnique('email',Input::get('email'),'id',Input::get('pds_id'));
}

exitJson($unique);