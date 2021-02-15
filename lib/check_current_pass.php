<?php 

require '../core/init.php';
include '../../../assets/js/cryptojs-aes-php-master/cryptojs-aes.php';


use Gender\Classes\Supports\Input;
use Gender\Classes\User;

if (Input::exists()) {

    check_referer_header();

    $user = new User;

    $current_pass = request('current_pass');

    exitJson($user->checkCurrentPassword(request('current_pass')));
}