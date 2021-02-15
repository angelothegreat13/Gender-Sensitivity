<?php 

require '../core/init.php';

use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;
use Gender\Classes\User;


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    csrf_protection();

    $user = new User;

    if (!$user->checkCurrentPassword(Input::get('currentPassword'))) {
        Session::put('errorMsg','Current Passwod is Incorrect');
        Redirect::back();
    }

    if (Input::get('newPassword') !== Input::get('confirmPassword')) {
        Session::put('errorMsg','The Password and Confirm Password do not match');
        Redirect::back();
    }

    $user->changePassword(Input::get('confirmPassword'));

    Session::put('successMsg','Password Successfully Changed');
    Redirect::back();
}

Redirect::to(404);