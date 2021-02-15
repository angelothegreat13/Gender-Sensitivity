<?php 

require_once '../core/init.php';

use Gender\Classes\Guest;
use Gender\Classes\GuestSession;
use Gender\Classes\GuestAudit;

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Session;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    csrf_protection();

    $guest = new Guest;
    $guest_session = new GuestSession;
    $guest_audit = new GuestAudit;

    $guest->save([
        'firstname' => Input::get('firstname'),
        'lastname' => Input::get('lastname'),
        'gender' => Input::get('gender'),
        'genderpref' => Input::get('gender_pref'),
        'source_id' => 2,
        'user_type_id' => Input::get('userType'),
        'ip_address' => get_ip_address(),
        'mac_address' => getMacAdd(),
        'server' => $_SERVER['SERVER_NAME'],
        'platform' => get_platform(),
        'browser' => get_user_browser()
    ]);

    $guest_id = $guest->latestID();
    
    $guest_session->save([
        'guest_id' => $guest_id,
        'session_code' => $guest_session->futureID().$guest_id 
    ]);

    Session::put('SESS_GENDER_GUEST_CODE',$guest_session->latestID().$guest_id); // Session ID + Guest ID
    Session::put('SESS_GENDER_GUEST_ID',$guest_id);
    Session::put('SESS_GENDER_SOURCE_ID',2);
    Session::put('SESS_GENDER_USER_TYPE_ID',Input::get('userType'));
    Session::put('SESS_GENDER_RESPONDENT_TYPE_ID',2);

    $guest_audit->log(
        2, // Menu ID - Guest Form
        3 // Action ID - Sign Up
    );

    Redirect::to('surveys/survey-form');
}

Redirect::to(404);