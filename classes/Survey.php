<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Survey
{
    private $_db;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function save($fields)
    {
        if (!$this->_db->insert('survey',$fields)) {
            throw new \Exception("There was a problem in Creating a Survey");
        }
    }

    public function latestID()
	{
		return $this->_db->lastID();
    }

    public function all()
    {
        $sql = "SELECT srvy.id AS survey_id, src.sourcedesc AS source, usr_type.user_typedesc AS user_type,
                CASE WHEN srvy.source_id = 1 
                     THEN CONCAT(usr.firstname,' ',usr.middlename,' ',usr.lastname) 
                     WHEN srvy.source_id = 2 
                     THEN CONCAT(gst.firstname,' ',gst.lastname) END AS person_name 
                FROM survey srvy 
                INNER JOIN global_ref.ref_sources src ON srvy.source_id = src.id 
                INNER JOIN global_ref.ref_usertype usr_type ON srvy.user_type_id = usr_type.id 
                LEFT JOIN guests gst ON srvy.guest_id = gst.id 
                LEFT JOIN systems.users usr ON srvy.user_id = usr.id 
                ORDER BY srvy.id DESC";

        $data = $this->_db->query($sql);

        if ($data->count()) {
            return $data->results();
        }

        return false;
    }

    public function table()
    {
        $sql = "SELECT sv.id AS survey_id, sc.sourcedesc, ut.user_typedesc, rt.name AS respondent ,
                CASE WHEN sv.respondent_type_id = 1 
                     THEN CONCAT(us.firstname,' ',us.middlename,' ',us.lastname) 
                     WHEN sv.respondent_type_id = 2 
                     THEN CONCAT(gs.firstname,' ',gs.lastname) 
                     END AS person_name, 
                CASE WHEN sv.respondent_type_id = 1 
                     THEN us.gender 
                     WHEN sv.respondent_type_id = 2 
                     THEN gs.gender 
                     END AS gender 
                FROM survey sv 
                INNER JOIN global_ref.ref_sources sc ON sv.source_id = sc.id 
                INNER JOIN global_ref.ref_usertype ut ON sv.user_type_id = ut.id 
                INNER JOIN respondent_types rt ON sv.respondent_type_id = rt.id 
                LEFT JOIN survey_guests sg ON sv.id = sg.survey_id 
                LEFT JOIN guests gs ON sg.guest_id = gs.id 
                LEFT JOIN survey_users su ON sv.id = su.survey_id 
                LEFT JOIN systems.users us ON su.user_id = us.id 
                ORDER BY survey_id DESC";

        $data = $this->_db->query($sql);        

        if ($data->count()) {
            return $data->results();
        }

        return false;
    }

   

}