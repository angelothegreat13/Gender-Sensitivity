<?php 
require_once '../core/init.php';

use Gender\Classes\Gender;
use Gender\Classes\GenderPreference;
use Gender\Classes\SurveyResult;
use Gender\Classes\Category;
use Gender\Classes\Supports\Input;

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $gender = new Gender;
    $gender_pref = new GenderPreference;
    $survey_result = new SurveyResult;
    $categories = new Category;

    switch (Input::get('report_name')) 
    {
        case 'total_gender':
            exitJson($gender -> totalNumberPerGender());
        break;

        case 'total_gender_pref':
            exitJson($gender_pref -> totalNumberPerGenderPreference());
        break;
    }

}