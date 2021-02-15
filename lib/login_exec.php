<?php 
require_once '../core/init.php';

use Gender\Classes\User;
use Gender\Classes\UserLog;
use Gender\Classes\LoginHistory;
use Gender\Classes\PasswordRetry;
use Gender\Classes\UserAudit;

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Redirect;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    csrf_protection();

    $user = new User;
    $login_history = new LoginHistory;
    $pass_retry = new PasswordRetry;    
    $user_audit = new UserAudit;

    $pass_retry->save([
        'username' => Input::get('username'),
        'ip_address' => get_ip_address()
    ]);

    if ($user->usernameOnlyExists(Input::get('username'),Input::get('password'))) {

        if (!$pass_retry->limitReached(Input::get('username'))) {
            Session::put('errorMsg',$pass_retry->attemptMsg());
        }
        else {
            Session::put('errorMsg',$pass_retry->limitReachedMsg());
        }

        Redirect::to('login');
    }

    if ($user->login( Input::get('username'),Input::get('password') )) 
    {   
        $pass_retry->refresh();
        $user_data = $user->data();

        $login_history->save([
            'user_id' => $user_data->id,
            'ip_address' => get_ip_address(), 
            'mac_address' => getMacAdd(),
            'server' => $_SERVER['SERVER_NAME'],
            'browser' => get_user_browser(), 
            'platform' => get_platform(),
        ]);

        $user->update($user_data->id,[
            'ipaddress' => get_ip_address(),
            'macaddress' => getMacAdd()
        ]);

        $user_audit->log(
            1, // Menu ID - Login Form
            1 // Action ID - Login
        );

        Session::put('SESS_GENDER_USER_ID', $user_data->id);
        Session::put('SESS_GENDER_EMPLOYEE_ID', $user_data->empcode);
        Session::put('SESS_GENDER_PASSENGER_ID', $user_data->passcode);
        Session::put('SESS_GENDER_CONCESSIONAIRE_ID', $user_data->concode);
        Session::put('SESS_GENDER_VISITOR_ID', $user_data->visitcode);
        Session::put('SESS_GENDER_USERNAME', $user_data->username);
        Session::put('SESS_GENDER_USER_LOGIN_HISTORY_ID', $login_history->latestID());
        Session::put('SESS_GENDER_SOURCE_ID', $user_data->source_id);
        Session::put('SESS_GENDER_USER_TYPE_ID',$user_data->user_type_id);
        Session::put('SESS_GENDER_RESPONDENT_TYPE_ID',1);
        Session::put('SESS_MODULE_CODE','0000000003'); //Gender Sensitivity System

        Redirect::to('dashboard');
    }

    Redirect::to('login-failed');   
}

Redirect::to(404);

  

