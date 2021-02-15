<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Input;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$pds_id = encrypt_url(Input::get('pds_id'));

	if (isset($_POST['edit'])) {
		Redirect::to('pds/edit-pds','?i='.$pds_id);		
	}

	if (isset($_POST['view'])) {
		Redirect::to('pds/view-pds','?i='.$pds_id);		
	}


}