<?php 
require_once '../core/init.php';

use Gender\Classes\Question;
use Gender\Classes\Answer;
use Gender\Classes\Survey;
use Gender\Classes\SurveyGuest;
use Gender\Classes\SurveyUser;
use Gender\Classes\SurveyEmployee;
use Gender\Classes\SurveyTransaction;
use Gender\Classes\UserSurveyTransaction;
use Gender\Classes\GuestSurveyTransaction;
use Gender\Classes\UserAudit;
use Gender\Classes\GuestAudit;

use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Input;


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	csrf_protection();
	
	$_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

	$question = new Question;
	$answer = new Answer;	
	$survey = new Survey;
	$survey_user = new SurveyUser;
	$survey_employee = new SurveyEmployee;
	$survey_guest = new SurveyGuest;
	$survey_trans = new SurveyTransaction;
	$user_survey_trans = new UserSurveyTransaction;
	$guest_survey_trans = new GuestSurveyTransaction;
	$user_audit = new UserAudit;
	$guest_audit = new GuestAudit;

	$source_id = Session::get('SESS_GENDER_SOURCE_ID');
	$user_type_id = Session::get('SESS_GENDER_USER_TYPE_ID');
	$respondent_type_id = Session::get('SESS_GENDER_RESPONDENT_TYPE_ID');
	$user_id = get_session('SESS_GENDER_USER_ID');
	$guest_id = get_session('SESS_GENDER_GUEST_ID');

	$survey->save([
		'source_id' => $source_id,
		'user_type_id' => $user_type_id,
		'respondent_type_id' => $respondent_type_id,
		'start_date' => Input::get('start_date')
	]);

	$survey_id = $survey->latestID();

	$survey_trans->save([
		'survey_id' => $survey_id,
		'action_id' => 5,
		'source_id' => $source_id,
		'user_type_id' => $user_type_id,
		'respondent_type_id' => $respondent_type_id,
		'ip_address' => get_ip_address(), 
        'mac_address' => getMacAdd(),
        'server' => $_SERVER['SERVER_NAME'],
        'browser' => get_user_browser(), 
        'platform' => get_platform()
	]);

	$survey_trans_id = $survey_trans->latestID();
	
	foreach ($question->getAllId() as $ques_data) 
	{   
		$choices = (isset($_POST['choice'.$ques_data->id])) ? $_POST['choice'.$ques_data->id] : '';
	
		if (is_array($choices)) 
		{
			foreach ($choices as $choice) {
				$answer -> save([
					'survey_id' => $survey_id,
					'question_id' => $ques_data->id,
					'choice_id' => $choice
				]);
			}
		}
		else {
			$answer -> save([
				'survey_id' => $survey_id,
				'question_id' => $ques_data->id,
				'choice_id' => $choices
			]);
		}
	}

	if (validate_session('SESS_GENDER_USER_ID')) 
	{
		$survey_user->save([
			'survey_id' => $survey_id,
			'user_id' => $user_id
		]);

		$survey_employee->save($survey_id);

		$user_survey_trans->save([
			'survey_trans_id' => $survey_trans_id,
			'user_id' => $user_id
		]);

		$user_audit->log(
	        3, // Menu ID - Survey Form
	        5 // Action ID - Take a Survey
	    );

		Session::put('successMsg','Survey Successfully Saved.');
		Redirect::to('surveys/surveys-list');
	}
	elseif (validate_session('SESS_GENDER_GUEST_ID')) 
	{
		$survey_guest->save([
			'survey_id' => $survey_id,
			'guest_id' => $guest_id
		]);

		$guest_survey_trans->save([
			'survey_trans_id' => $survey_trans_id,
			'guest_id' => $guest_id
		]);

		$guest_audit->log(
	        3, // Menu ID - Survey Form
	        5 // Action ID - Take a Survey
	    );

		$i = md5(microtime());

		Session::put('thank-you',$i);
		Redirect::to('thank-you','?i='.$i);
	}

}

Redirect::to(404);