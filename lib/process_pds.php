<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;

use Gender\Classes\References\Pds\PdsMain;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$pds = new PdsMain;


}
else {
	Redirect::to(404);
}

