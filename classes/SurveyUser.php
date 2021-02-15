<?php namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class SurveyUser {

    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function save($fields)
    {
        if (!$this->_db->insert('survey_users',$fields)) {
            throw new \Exception("There was a problem in Creating a Survey User");
        }
    }

    public function getData($user_id = null)
    {
        $sql = "SELECT sv.id AS survey_id, sc.sourcedesc, ut.user_typedesc, 
                CONCAT(us.firstname,' ',us.middlename,' ',us.lastname,' ',us.suffix) AS respondent, 
                us.gender, sv.start_date, sv.end_date 
                FROM survey_users su 
                INNER JOIN survey sv ON su.survey_id = sv.id 
                INNER JOIN global_ref.ref_sources sc ON sv.source_id = sc.id 
                INNER JOIN global_ref.ref_usertype ut ON sv.user_type_id = ut.id 
                INNER JOIN systems.users us ON su.user_id = us.id ";

        if ($user_id) 
        {
            $sql .= "WHERE su.user_id = ? ORDER BY su.survey_id DESC";

            $data = $this->_db->query($sql,[$user_id]); 
            
            return $data->results();
        }
        else {
            $sql .= "ORDER BY su.survey_id DESC";

            $data = $this->_db->query($sql); 

            return $data->results();
        }
    }

    

    

}