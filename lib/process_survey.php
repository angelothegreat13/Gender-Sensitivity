<?php 
require_once '../core/init.php';

use Gender\Classes\Survey;
use Gender\Classes\Question;
use Gender\Classes\PDS;

use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Redirect;

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $survey = new Survey;
    $questions = new Question;
    $PDS = new PDS;

    if (isset($_POST['save_survey_btn'])) 
    {   

        foreach ($questions -> getAllId() as $question) 
        {   
            $answers = (isset($_POST['choice'.$question->id])) ? $_POST['choice'.$question->id] : '';


            if (is_array($answers)) 
            {
                foreach ($answers as $answer) {
                    $survey -> saveAnswer([
                        'trans_id' => sanitize($_POST['trans_id']),
                        'question_id' => $question->id,
                        'answer' => $answer
                    ]);
                }
            }
            else {
                $survey -> saveAnswer(array(
                    'trans_id' => sanitize($_POST['trans_id']),
                    'question_id' => $question->id,
                    'answer' => $answers
                ));
            }
        }
        
        $survey->save($_POST['trans_id'],[
            'survey_id' =>  sanitize((int)$PDS -> appNumber($_POST['employee_id']).$_POST['employee_id']),
            'employee_id' => sanitize($_POST['employee_id']),
            'survey_end' => date('Y/m/d H:i:s', time())
        ]);

        Session::put('successMsg','Survey Successfully Saved.');
        Redirect::to('survey-lists');
    
    }
    elseif (isset($_POST['cancel_survey_btn'])) {

        $survey->cancel(sanitize($_POST['trans_id']));
        Redirect::to('survey-lists');
    
    }

    Redirect::to(404);
}

Redirect::to(404);

?>