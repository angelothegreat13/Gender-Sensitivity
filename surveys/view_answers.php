<?php 
require '../core/init.php';
include '../includes/styles.php';
include '../includes/navbar.php';

auth_guard();

use Gender\Classes\Category;
use Gender\Classes\Question;
use Gender\Classes\Choice;
use Gender\Classes\Answer;
use Gender\Classes\SurveyTransaction;
use Gender\Classes\UserSurveyTransaction;
use Gender\Classes\UserAudit;

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Session;

$category = new Category;
$question = new Question;
$choice = new Choice;
$answer = new Answer;
$survey_trans = new SurveyTransaction;
$user_survey_trans = new UserSurveyTransaction;
$user_audit = new UserAudit;

$survey_id = decrypt_url(Input::get('i'));

$survey_trans->save([
    'survey_id' => $survey_id,
    'action_id' => 4,
    'source_id' => Session::get('SESS_GENDER_SOURCE_ID'),
    'user_type_id' => Session::get('SESS_GENDER_USER_TYPE_ID'),
    'respondent_type_id' => Session::get('SESS_GENDER_RESPONDENT_TYPE_ID'),
    'ip_address' => get_ip_address(), 
    'mac_address' => getMacAdd(),
    'server' => $_SERVER['SERVER_NAME'],
    'browser' => get_user_browser(), 
    'platform' => get_platform()
]);

$survey_trans_id = $survey_trans->latestID();

$user_survey_trans->save([
    'survey_trans_id' => $survey_trans_id,
    'user_id' => Session::get('SESS_GENDER_USER_ID')
]);

$user_audit->log(
    12, // Menu ID - Surveys List
    12 // Action ID - View
);

?>

<div class="my-container">

    <div class="row mt-40">
    
        <div class="col-md-12">

            <form action="<?=MODULE_URL;?>surveys/print_survey_answers.php" method="POST" target="_blank">          

                <input type="hidden" name="survey_id" value="<?=$survey_id;?>">
            
                <div class="well well-md">
                    <div class="text-right">
                        <a href="<?=MODULE_URL;?>surveys/surveys-list.php" class="btn my-btn mr-3">
                            <i class="fa fa-arrow-left gamboge"></i> Back
                        </a>

                        <button type="submit" name="print" class="btn my-btn">
                            <i class="fas fa-print radical-red"></i> Print Answers
                        </button>
                    </div>
                </div>

            </form>  

            <div class="panel panel-default">
                
                <div class="panel-heading">
                    <i class="fas fa-poll steel-blue"></i> User Answers
                </div>
                
                <div class="panel-body">

                    <div role="tabpanel">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified survey-tabs" role="tablist">
                            <?php foreach ($category->list() as $categ_data) :?>
                            <li role="presentation" class="<?=survey_active($categ_data->id);?>">
                                <a href="#<?=camelCaseString($categ_data->categdesc);?>" aria-controls="<?=camelCaseString($categ_data->categdesc);?>" role="tab" data-toggle="tab" class="capitalize"><?=$categ_data->categdesc;?></a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                
                        <!-- Tab Content -->
                        <div class="tab-content">
                           <?php foreach ($category->list() as $categ_data) :?>
                            <div role="tabpanel" class="tab-pane survey-tab-panel <?=survey_active($categ_data->id);?>" id="<?=camelCaseString($categ_data->categdesc);?>">

                                <br><h3 class="survey-category"><?=$categ_data->categdesc;?></h3><br>    
                                
                                <?php $num = 1;
                                foreach ($question->byCategory($categ_data->id) as $ques_data):?>
                                <div class="container-fluid mb-15">
                                    
                                    <div class="col-md-12">
                                        <label class="survey-question">
                                            <?=$num++.'. '. $ques_data->questiondesc.' ?';?>
                                        </label>
                                    </div>
                                    
                                    <?php foreach ($answer->takenByUser($survey_id,$ques_data->id) as $answer_taken) :?>
                                    <div class="col-md-6">
                                        <div class="checkbox survey-box ml-14">
                                            <label>
                                                <i class="far fa-circle choice-circle <?=choice_taken_color($answer_taken->choicedesc);?>"></i>
                                                <?=choice_taken($answer_taken->choicedesc);?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endforeach;?>

                                </div>
                                <?php endforeach;?>

                            </div>
                            <?php endforeach;?>
                            
                        </div>

                    </div>

                </div>
            
            </div>

        </div>

    </div>
  
</div>

<?php 
    include '../includes/scripts.php';
    include '../includes/footer.php';
?>


