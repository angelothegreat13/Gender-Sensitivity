<?php namespace Gender\Classes;

use Gender\Core\DB;
use Gender\Classes\Supports\Config;

class Answer {
    
    private $_db;

    public function __construct()
    {
        $this -> _db = DB::instance(Config::get('mysql/genderdb'));
    }

    public function save($fields)
	{
		if (!$this -> _db -> insert('survey_answer',$fields)) {
            throw new \Exception("There was a problem in Saving an Answer");
        }
    }

    public function latestID()
	{
		return $this->_db->lastID();
    }

    public function takenByUser($survey_id,$question_id)
    {
        $sql = "SELECT ch.choicedesc  
                FROM survey_answer sa 
                LEFT JOIN refsurveychoices ch ON choice_id = ch.id 
                WHERE sa.survey_id = ? AND sa.question_id = ?";

        $data = $this->_db->query($sql,[$survey_id,$question_id]);

        return $data->results();
    }


    /**
     * Survey Analysis All (Internal)
     * Survey Analysis All (External) 
     * Survey Analysis All (Internal|External)
     * @param $source = source_id (Internal/External/Both)
     * @param $survey_category = survey category id
     * @param $date_from = start date
     * @param $date_to = end date
     */
    public function surveyAnalysisBySource($source,$survey_category,$date_from,$date_to)
    {
        $where = '';
        $params = [$date_from,$date_to];

        if ($source != 'all') {
            $where .= 'AND sv.source_id = ? ';
            $params[] = $source;
        }

        if ($survey_category != 'all') {
            $where .= 'AND sct.id = ?';
            $params[] = $survey_category;
        }

        $sql = "SELECT sq.questiondesc AS QUESTION,
                (CASE WHEN sc.choicedesc <> '0' THEN sc.choicedesc ELSE 'No Answer' END) AS CHOICE, 
                COUNT(*) AS TOTAL 
                FROM survey_answer sa 
                INNER JOIN refsurveyquestion sq ON sa.question_id = sq.id 
                INNER JOIN refsurveycateg sct ON sq.categ_id = sct.id 
                LEFT JOIN refsurveychoices sc ON sa.choice_id = sc.id 
                INNER JOIN survey sv ON sa.survey_id = sv.id 
                WHERE sct.deleted = 0 AND sv.start_date >= ? AND sv.start_date <= ? {$where}  
                GROUP BY sa.question_id,sa.choice_id 
                ORDER BY sa.question_id";

        $data = $this->_db->query($sql,$params);
        
        return $data->results();        
    }


    public function surveyAnalysisPerOrganization($date_from,$date_to)
    {
        $sql = "SELECT sq.questiondesc AS QUESTION, of.offcod AS OFFICE,  
                (CASE WHEN sc.choicedesc <> '0' THEN sc.choicedesc ELSE 'No Answer' END) AS CHOICE, COUNT(*) AS TOTAL 
                FROM survey_answer sa 
                INNER JOIN refsurveyquestion sq ON sa.question_id = sq.id 
                INNER JOIN refsurveycateg sct ON sq.categ_id = sct.id 
                LEFT JOIN refsurveychoices sc ON sa.choice_id = sc.id 
                INNER JOIN survey sv ON sa.survey_id = sv.id
                INNER JOIN survey_employees se ON sv.id = se.survey_id 
                INNER JOIN global_ref.tpdsmaininfo tp ON se.employee_id = tp.empno 
                INNER JOIN global_ref.roffinfo of ON tp.office = of.offcode 
                WHERE sct.deleted = 0 AND sv.start_date >= ? AND sv.start_date <= ?
                GROUP BY sa.question_id,of.offcode,sa.choice_id 
                ORDER BY sa.question_id";

        $data = $this->_db->query($sql,[$date_from,$date_to]);

        return $data->results();
    }


}