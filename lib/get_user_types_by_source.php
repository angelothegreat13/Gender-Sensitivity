<?php 

require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;

use Gender\Classes\References\Settings\UserType;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$user_type = new UserType;

	$data = $user_type->bySource(Input::get('source'));

	exitJson($data);

}
else {
	Redirect::to(404);
}

