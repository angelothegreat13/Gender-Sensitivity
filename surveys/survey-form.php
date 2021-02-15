<?php 
require '../core/init.php';
include '../includes/styles.php';
include '../includes/navbar.php';

use Gender\Classes\Category;
use Gender\Classes\Question;
use Gender\Classes\Choice;
use Gender\Classes\Guest;
use Gender\Classes\UserAudit;
use Gender\Classes\GuestAudit;

use Gender\Classes\Supports\Session;

auth_guard('user|guest');

$category = new Category;
$question = new Question;
$choice = new Choice;
$guest = new Guest;
$user_audit = new UserAudit;
$guest_audit = new GuestAudit;

$guest_data = $guest->data();

if (validate_session('SESS_GENDER_USER_ID')) {

    $user_audit->log(
        3, // Menu ID - Survey Form
        12 // Action ID - View
    );

}

if (validate_session('SESS_GENDER_GUEST_CODE')) {

    $guest_audit->log(
        3, // Menu ID - Survey Form
        12 // Action ID - View
    );

}

?>

<div class="my-container">

    <div class="row mt-40">

        <div class="col-md-3">

            <?php if(validate_session('SESS_GENDER_GUEST_CODE')):?>
            <!-- Guest Information -->
            <div class="panel panel-default">
            
                <div class="panel-heading">
                    <i class="fas fa-user steel-blue"></i> Guest Information
                </div>
            
                <div class="panel-body survey-guide-box">
                    
                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" class="form-control" value="<?=anonymous($guest_data->firstname);?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" class="form-control" value="<?=anonymous($guest_data->lastname);?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Gender:</label>
                        <input type="text" class="form-control" value="<?=anonymous($guest_data->gender);?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>User Type:</label>
                        <input type="text" class="form-control" value="<?=$guest_data->user_type;?>" readonly>
                    </div>

                </div>

            </div>
            <!-- End of Guest Information -->
            <?php endif;?>


            <!-- Guidelines -->
            <div class="panel panel-default">
            
                <div class="panel-heading">
                    <i class="fas fa-info-circle picton-blue"></i> Guidelines
                </div>
            
                <div class="panel-body survey-guide-box">
                    
                    <ul class="list-group no-radius">
                        <li class="list-group-item">
                            <a data-toggle="modal" href="#survey-notes" class="no-underline ls-1">
                                Notes&nbsp; <i class="fas fa-sticky-note jungle-green"></i>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a data-toggle="modal" href="#survey-instruction" class="no-underline ls-1">
                                Instruction&nbsp; <i class="fas fa-book-open radical-red"></i>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a data-toggle="modal" href="#survey-categories" class="no-underline ls-1">
                                Categories&nbsp; <i class="fas fa-th-list gamboge"></i>
                            </a>
                        </li>
                    </ul>

                </div>

            </div>
            <!-- End of Guidelines -->
        
        </div>

        <div class="col-md-9">

            <form action="<?=MODULE_URL;?>lib/process_survey_form.php" method="POST" id="surveyForm">

            <div class="well well-md">
                <div class="text-right">
                    
                    <a href="<?=MODULE_URL.'lib/cancel_survey.php';?>" class="btn my-btn mr-3">
                        <i class="fas fa-ban medium-crimson"></i> Cancel
                    </a>
            

                    <button type="submit" name="submitSurvey" id="submitSurvey" class="btn my-btn">
                        <i class="fas fa-play steel-blue"></i> Submit Answer
                    </button>
                
                </div>
            </div>

            <div class="panel panel-default">
                
                <div class="panel-heading">
                    <i class="fas fa-poll bell-flower"></i> Survey Questionnaire
                </div>
                
                <div class="panel-body">

                    <div role="tabpanel">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified survey-tabs" role="tablist">
                            <?php foreach ($category->list() as $categ_data) :?>
                            <li role="presentation" class="<?php echo survey_active($categ_data->id);?>">
                                <a href="#<?php echo camelCaseString($categ_data->categdesc);?>" aria-controls="<?php echo camelCaseString($categ_data->categdesc);?>" role="tab" data-toggle="tab" class="capitalize"><?php echo $categ_data->categdesc;?></a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                
                        <!-- Tab Content -->
                        <div class="tab-content">
                           <?php foreach ($category-> list() as $categ_data) :?>
                            <div role="tabpanel" class="tab-pane survey-tab-panel <?php echo survey_active($categ_data->id);?>" id="<?php echo camelCaseString($categ_data->categdesc);?>">

                                <br><h3 class="survey-category"><?php echo $categ_data->categdesc;?></h3><br>    
                                
                                <?php $num = 1;
                                foreach ($question -> byCategory($categ_data->id) as $ques_data):?>
                                <div class="container-fluid mb-15">
                                    
                                    <div class="col-md-12">
                                        <label class="survey-question"><?php echo $num++.'. '. $ques_data->questiondesc.' ?';?></label>
                                    </div>
                                    
                                    <?php foreach ($choice->byQuestionId($ques_data->id) as $choice_data) :?>
                                    <div class="<?php 
                                    $choice_len = count($choice->byQuestionId($ques_data->id));
                                    echo survey_choice_column($choice_len);
                                    ?>">
                                        <div class="checkbox survey-box">
                                            <label class="survey-choices">
                                            <input type="<?php echo survey_input_type($choice_data->questiontype_id);?>" class="choices survey-<?php echo survey_input_type($choice_data->questiontype_id);?>" name="<?php echo survey_input_type_name($choice_data->questiontype_id,'choice'.$ques_data->id);?>" value="<?php echo $choice_data->id;?>">&nbsp; <?php echo ucwords($choice_data -> choicedesc);?></label>
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

            <input type="hidden" name="start_date" value="<?=dateNow();?>">
            <input type="hidden" name="token" value="<?=csrf_field();?>">

            </form>

        </div>

    </div>
    
    <!-- Survey Notes Guideline -->
    <div class="modal fade" id="survey-notes">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title my-green">Notes <i class="fa fa-info-circle jungle-green"></i></h4>
                </div>
                
                <div class="modal-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati facere voluptatem vel ut blanditiis impedit cum consectetur ex et voluptas recusandae quidem repudiandae natus autem magni, iste earum distinctio culpa.
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn my-btn" data-dismiss="modal"><i class="fa fa-times radical-red"></i> Close</button>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Survey Notes Instruction -->
    <div class="modal fade" id="survey-instruction">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title my-green">Instruction <i class="fa fa-info-circle radical-red"></i></h4>
                </div>
                
                <div class="modal-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati facere voluptatem vel ut blanditiis impedit cum consectetur ex et voluptas recusandae quidem repudiandae natus autem magni, iste earum distinctio culpa.
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn my-btn" data-dismiss="modal"><i class="fa fa-times radical-red"></i> Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Survey Notes Categories -->
    <div class="modal fade" id="survey-categories">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title my-green">Categories <i class="fa fa-info-circle gamboge"></i></h4>
                </div>
                
                <div class="modal-body">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati facere voluptatem vel ut blanditiis impedit cum consectetur ex et voluptas recusandae quidem repudiandae natus autem magni, iste earum distinctio culpa.
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn my-btn" data-dismiss="modal"><i class="fa fa-times radical-red"></i> Close</button>
                </div>

            </div>
        </div>
    </div>

</div>

<?php 
include '../includes/scripts.php';
include '../includes/footer.php';
?>
<script type="text/javascript">

$("#submitSurvey").click(() => {

    if ($(".choices:checked").val() == null) {
        displayError('Please fill up Survey Form');
        return false;
    } 
    else {
        alertify.confirm('Confirmation Message', '<label class="text-info"><i class="fas fa-info"></i>&nbsp; Are you sure you want to submit this Survey Form?</label>',
        () => {
            $("#surveyForm").submit();
        },() => { });
    }

    return false;
});
    



</script>