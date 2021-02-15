<?php 

require '../core/init.php';

use Gender\Classes\SurveyUser;
use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Session;

if (Input::exists()) {

    $survey_user = new SurveyUser;

    $data = $survey_user->getData(Session::get('SESS_GENDER_USER_ID'));

    exitJson($data);
}
    
