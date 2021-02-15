<?php 

use Gender\Classes\References\Settings\UserType;
use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;

require_once '../core/init.php';

if (Input::exists('GET')) {

    $user_type = new UserType;

    exitJson($user_type->bySource(Input::get('s')));
}