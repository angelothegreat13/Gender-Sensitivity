<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;

use Gender\Classes\References\Pds\PdsMain;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $pds = new PdsMain;
    
    $data = $pds->alreadyExists(Input::get('id_type'),Input::get('id'));

    exitJson($data);
}