<?php 

namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class SurveyResult
{
    private $_db,
            $_employee;

    public function __construct()
    {
        $this -> _db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function surveyedEmployee($trans_id)
    {
        $sql = "SELECT a.survey_start,a.survey_end,b.empno,b.fname,b.mname,b.lname,b.suffix,b.sex 
                FROM genderdb.surveytrans a 
                INNER JOIN workforcedb.tpdsmaininfo b ON a.employee_id = b.empno 
                WHERE a.trans_id = ?";
        $name = $this -> _db -> query($sql,[$trans_id]);
        if ($name -> count()) {
            $this -> _employee = $name -> first(); 
            return true;
        }
        return false;
    }

    public function employee()
    {
        return $this -> _employee;
    }

    public function questionsByTransID($trans_id,$categ_id)
    {
        $sql = "SELECT DISTINCT a.question_id,b.questiondesc FROM survey_answer a 
                INNER JOIN refsurveyquestion b ON a.question_id = b.id
                WHERE a.trans_id = ? AND b.categ_id = ? 
                ORDER BY a.question_id ASC";
        return $this -> _db -> query($sql,[$trans_id,$categ_id]) -> results();
    }

    public function choicesByTransID($trans_id,$question_id)
    {   
        $sql = "SELECT answer FROM survey_answer WHERE trans_id = ? AND question_id = ?";
        return $this -> _db -> query($sql,[$trans_id,$question_id]) -> results();
    }

    public function questionsByCategory($categ_id)
    {
        $sql = "SELECT DISTINCT a.question_id,b.questiondesc FROM survey_answer a 
                INNER JOIN refsurveyquestion b ON a.question_id = b.id 
                WHERE b.categ_id = ? ORDER BY a.question_id ASC";
        return $this -> _db -> query($sql,[$categ_id]) -> results();
    }

    public function answersTally($question_id)
    {
        $sql = "SELECT a.answer AS answerdesc,count(row) AS total
                FROM survey_answer a 
                INNER JOIN refsurveyquestion b ON a.question_id = b.id
                WHERE a.question_id = ?
                GROUP BY a.question_id,a.answer ORDER BY a.question_id ";
        return $this -> _db -> query($sql,[$question_id]) -> results();
    }

    public function newAnswerTally()
    {
        $sql = "SELECT sq.questiondesc,
                (CASE WHEN sa.choice_id <> 0 
                      THEN sc.choicedesc 
                      ELSE 'No Answer' END) AS choice,COUNT(*) AS TOTAL 
                FROM survey_answer sa 
                INNER JOIN refsurveyquestion sq ON sa.question_id = sq.id 
                LEFT JOIN refsurveychoices sc ON sa.choice_id = sc.id 
                GROUP BY sa.question_id,sa.choice_id 
                ORDER BY sa.question_id";

        // We will use a condion where sa.question_id = ? later
    }

    public function sqlGroup()
    {
        // SELECT COUNT(*) 
        // FROM permissions 
        // WHERE group_setup_id = 8 AND name = 'doc-upload' 
    }
    
   





    
}



?>