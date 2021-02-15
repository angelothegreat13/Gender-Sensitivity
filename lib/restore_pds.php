<?php
require_once '../core/init.php';

use Gender\Classes\UserAudit;

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Session;

use Gender\Classes\References\Pds\PdsMain;
use Gender\Classes\References\Pds\PdsTransaction;

$user_audit = new UserAudit;
$pds_trans = new PdsTransaction;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$pds = new PdsMain;

	$pds->restore(Input::get('pds_id'));
        
    Session::put('successMsg','Personal Data Sheet Successfully Restored');

    $user_audit->log(
	    17, // Menu ID - Personal Data Sheet
	    17 // Action ID - Restore
	);

    $pds_trans->save(Input::get('pds_id'),17); //Action Id = Restore

    exitJson('success');
}