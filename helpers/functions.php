<?php 

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Config;

use Gender\Classes\UserAudit;

function surveyQuestionType($questiontype_id)
{
    if ($questiontype_id == 1) {
        return 'survey-radio';
    }
    elseif ($questiontype_id == 2) {
        return 'survey-checkbox';
    }
}

function surveyMultipleAnswer($questiontype_id,$choices_name)
{   
    //1  = mutiple choice (one answer)
    //2  = mutiple choice (multiple answer)
    if ($questiontype_id == 1) {
        return $choices_name;
    }
    elseif ($questiontype_id == 2) 
    {
        return $choices_name.'[]';
    }
}

function surveyAnswerType($questiontype_id)
{
    if ($questiontype_id == 1) {
        return 'radio';
    }
    elseif ($questiontype_id == 2) {
        return 'checkbox';
    }
}

function choice_taken($choice)
{   
    return ($choice == '') ? 'No Answer' : ucwords($choice) ;
}

function choice_taken_color($choice)
{
    return ($choice == '') ? 'radical-red' : 'my-green' ;
}

function survey_active($id)
{
    return ($id == '0000000001') ? 'active' : '';
}

function survey_choice_column($len)
{
    return ($len < 5) ? "col-md-12" : "col-md-6" ;
}

function survey_input_type($question_type_id)
{
    if ($question_type_id == 1) {
        return 'radio';
    }
    elseif ($question_type_id == 2) {
        return 'checkbox';
    }
}

function survey_input_type_name($question_type_id,$choices_name)
{   
    //1  = mutiple choice (one answer)
    //2  = mutiple choice (multiple answer)
    if ($question_type_id == 1) {
        return $choices_name;
    }
    elseif ($question_type_id == 2) {
        return $choices_name.'[]';
    }
}

function page_number($page)
{
    if (!$page) {
        $page_num = 1;
    }
    else {
        $page_num = $page;
    }

    return $page_num;
}

/* Start of PDS functions */

function fill_permanent_address($address_type) 
{
    return [

        'per_room_num' => post($address_type.'_room_num'),
        'per_building_name' => post($address_type.'_building_name'),
        'per_building_num' => post($address_type.'_building_num'),
        'per_street' => post($address_type.'_street'),
        'per_subdivision' => post($address_type.'_subdivision'),
        'per_district' => post($address_type.'_district'),
        'per_regncode' => post($address_type.'_region'),
        'per_provcode' => post($address_type.'_province'),
        'per_municode' => post($address_type.'_municipality'),
        'per_brgycode' => post($address_type.'_brgy'),
        'per_zipcode' => post($address_type.'_zip_code')

    ];  
}

function pds_correspanding_id($pds_data) 
{ 
    $pds_type = $pds_data->pds_type_id;

    switch ($pds_type) {

        case '1': return $pds_data->empno; break;
            
        case '2': return $pds_data->passcode; break;

        case '3': return $pds_data->concode; break;
            
        case '4': return $pds_data->visitcode; break;
        
    }
}

function pds_correspanding_lbl($pds_type)
{
    switch ($pds_type) {

        case '1': return 'Employee'; break;
            
        case '2': return 'Passenger'; break;

        case '3': return 'Concessionaire'; break;
            
        case '4': return 'Visitor'; break;
        
    }
}


