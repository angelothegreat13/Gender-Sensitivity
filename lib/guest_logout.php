<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Session;

use Gender\Classes\GuestAudit;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    csrf_protection();

    $guest_audit = new GuestAudit;

    if (isset($_POST['survey_again'])) 
    {
    	$guest_audit->log(
	        4, // Menu ID - Thank You Page
	        6 // Action ID - Take a Survey Again
    	);

    	Redirect::to('surveys/survey-form');
    }

    if (isset($_POST['logout'])) 
    {
    	$guest_audit->log(
	        4, // Menu ID - Thank You Page
	        2 // Action ID - Logout
    	);

	    session_destroy_forever();
	
	    Redirect::to('guest-form');
    }
}

Redirect::to(404);