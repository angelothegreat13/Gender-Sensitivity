<?php 
require_once '../core/init.php';

use Gender\Classes\UserAudit;
use Gender\Classes\GuestAudit;

use Gender\Classes\Supports\Redirect;

if (validate_session('SESS_GENDER_USER_ID')) {

    $user_audit = new UserAudit;

    $user_audit->log(
        3, // Menu ID - Survey Form
        18 // Action ID - Cancel
    );

    Redirect::to('surveys/surveys-list');
}

if (validate_session('SESS_GENDER_GUEST_ID')) {

	$guest_audit = new GuestAudit;

	$guest_audit->log(
	    3, // Menu ID - Survey Form
	    18 // Action ID - Cancel
	);

	session_destroy_forever();

	Redirect::to('guest-form');

}
