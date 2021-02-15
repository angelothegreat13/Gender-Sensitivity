<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;

use Gender\Classes\References\Settings\UserType;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$pds_type = new UserType;

	$pds_type->find(Input::get('pds_type'));

	exitJson($pds_type->data()->source_id);
}
else {
	Redirect::to(404);
}