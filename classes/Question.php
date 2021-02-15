<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Question
{
    private $_db;

    public function __construct()
    {
        $this -> _db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function byCategory($categ_id)
    {   
        $sql = "SELECT * FROM refsurveyquestion WHERE categ_id = ? ORDER BY id ASC";
        
        return $this -> _db -> query($sql,[$categ_id]) -> results();
    }

    public function total()
    {
        return $this -> _db -> query("SELECT COUNT(id) as total FROM refsurveyquestion") -> first() -> total; 
    }

    public function getAllId()
    {
        return $this -> _db -> query("SELECT id FROM refsurveyquestion ORDER BY id ASC") -> results();
    }

    public function choices($question_id)
    {
        $sql = "SELECT b.questiontype_id,a.choicedesc FROM refsurveychoices a 
                INNER JOIN refsurveyquestion b ON a.question_id = b.id 
                WHERE a.question_id = ?";
        
        return $this -> _db -> query($sql,[$question_id]) -> results();        
    }
}

?>