<?php
require_once '../core/init.php';

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Input;

use Gender\Classes\References\Address\Barangay;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$barangay = new Barangay;

	check_referer_header();

	$barangays = $barangay->sort(Input::get('region_id'),Input::get('province_id'),Input::get('municipality_id'));

	exitJson($barangays);
}
else {
	Redirect::to(404);
}