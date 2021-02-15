<?php
require_once 'core/init.php';

use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Redirect;

if (!Session::exists('SESS_GENDER_USER_ID') || Session::get('SESS_GENDER_USER_ID') == NULL) {
	Redirect::to('login');
}

Redirect::to('dashboard');
?>


