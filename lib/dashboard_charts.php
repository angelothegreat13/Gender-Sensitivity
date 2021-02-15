<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;

use Gender\Classes\GenderPreference;
use Gender\Classes\Gender;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    $gender = new Gender;
    $gender_pref = new GenderPreference;

    switch (Input::get('mode')) 
    {
        case 'gender_total':
            exitJson($gender -> totalNumberPerGender());
        break;

        case 'gender_pref_total':
            exitJson($gender_pref -> totalNumberPerGenderPreference());
        break;
    }
}
else {
    Redirect::to(404);
}