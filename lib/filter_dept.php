<?php 
require_once '../core/init.php';

use Gender\Classes\References\Organizations\Department;
use Gender\Classes\Supports\Redirect;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $department = new Department;
  
    check_referer_header();

    $departments = $department->sort(request('offcode'));

    exitJson($departments);
}
else {
    Redirect::to(404);
}


