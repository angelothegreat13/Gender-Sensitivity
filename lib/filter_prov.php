<?php
require_once '../core/init.php';

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Input;

use Gender\Classes\References\Address\Province;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$province = new Province;

	check_referer_header();

	$provinces = $province->sort(Input::get('region_id'));

	exitJson($provinces);
}
else {
	Redirect::to(404);
}