<?php 

require_once '../core/init.php';

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Input;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$survey_id = encrypt_url(Input::get('survey_id'));

	if (isset($_POST['view_answers'])) {
		Redirect::to('surveys/view_answers','?i='.$survey_id);		
	}

	
}