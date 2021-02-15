<?php namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Choice {

    private $_db,
            $_data;

    public function __construct()
    {
        $this->_db = DB::instance(Config::get('mysql/genderdb'));        
    }

    public function byQuestionId($question_id)
    {
        $sql = "SELECT a.id,a.choicedesc,b.questiontype_id 
                FROM refsurveychoices a 
                INNER JOIN refsurveyquestion b ON a.question_id = b.id 
                WHERE a.question_id = ?";

        return $this -> _db -> query($sql,[$question_id])->results(); 
    }

}