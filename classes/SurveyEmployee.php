<?php namespace Gender\Classes;

use Gender\Core\DB;

use Gender\Classes\Supports\Config;
use Gender\Classes\Supports\Session;

class SurveyEmployee {

	private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function store($fields)
    {
        if (!$this->_db->insert('survey_employees',$fields)) {
            throw new \Exception("There was a problem in Creating a Survey Employee");
        }
    }

    public function save($survey_id)
    {
    	if (validate_session('SESS_GENDER_EMPLOYEE_ID')) {

    		$this->store([
				'survey_id' => $survey_id,
				'user_id' => Session::get('SESS_GENDER_USER_ID'),
				'employee_id' => Session::get('SESS_GENDER_EMPLOYEE_ID')
			]);

    	}
    }



}

