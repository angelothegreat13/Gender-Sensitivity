<?php 
require_once '../core/init.php';

use Gender\Classes\References\Pds\PdsMain;
use Gender\Classes\References\Pds\PdsTransaction;

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Session;

use Gender\Classes\UserAudit;

$user_audit = new UserAudit;
$pds_trans = new PdsTransaction;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$pds = new PdsMain;

	$pds->delete(Input::get('pds_id'));

    Session::put('successMsg','Personal Data Sheet Successfully Deleted');

    $user_audit->log(
	    17, // Menu ID - Personal Data Sheet
	    11 // Action ID - Delete
	);

    $pds_trans->save(Input::get('pds_id'),11); //Action Id = Delete

    exitJson('success');
}
