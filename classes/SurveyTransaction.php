<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class SurveyTransaction
{
    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function save($fields)
	{
		if (!$this->_db->insert('survey_trans',$fields)) {
            throw new \Exception("There was a problem in Saving a Document");
        }
	}

    public function latestID()
	{
		return $this->_db->lastID();
    }

}