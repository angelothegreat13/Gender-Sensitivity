<?php
require_once '../core/init.php';

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Input;

use Gender\Classes\References\Address\Municipality;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$municipality = new Municipality;

	check_referer_header();

	$municipalities = $municipality->sort(Input::get('region_id'),Input::get('province_id'));

	exitJson($municipalities);
}
else {
	Redirect::to(404);
}