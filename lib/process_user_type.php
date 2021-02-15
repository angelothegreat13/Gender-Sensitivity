<?php 

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

require_once '../core/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $key = Key::createNewRandomKey();

    $e_source = Crypto::encrypt(Input::get('source'),$key);
    $e_user_type = Crypto::encrypt(Input::get('user-type'),$key);

    // echo Crypto::decrypt($e_source,$key);
    // echo Crypto::decrypt($e_user_type,$key);

    echo $e_source ;

    Redirect::to('includes/forms/user-employee-form');

    // include_once INCLUDES.'forms/user-employee-form.php'; 
}

// Redirect::to(404);