<?php 
require_once '../core/init.php';

use Gender\Classes\References\Organizations\Division;
use Gender\Classes\Supports\Redirect;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $division = new Division;
  
	check_referer_header();

    $divisions = $division->sort(request('deptcode'));

    exitJson($divisions);
}
else {
    Redirect::to(404);
}



