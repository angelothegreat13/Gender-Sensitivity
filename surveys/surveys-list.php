<?php 
require '../core/init.php';
include '../includes/styles.php';
include '../includes/navbar.php';

use Gender\Classes\Supports\Session;

use Gender\Classes\Survey;
use Gender\Classes\UserAudit;

auth_guard();

$user_audit = new UserAudit;

$user_audit->log(
    7, // Menu ID - Surveys List
    12 // Action ID - View
);

?>

<div class="container-fluid">

    <div class="col-md-12">
    <?php Session::message();?>
    
    <form action="<?=MODULE_URL;?>lib/process_survey_tbl.php" method="POST">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="pull-right">
                    <button type="submit" name="view_answers" id="view_answers" class="btn btn-md my-btn mr-3">
                        <i class="fa fa-eye steel-blue"></i> View Answers
                    </button>    
                    <a href="<?php echo MODULE_URL;?>surveys/survey-form.php" class="btn btn-md my-btn">
                        <i class="fas fa-poll radical-red"></i> Take a Survey
                    </a>    
                </div>
            </div>
        </div>
        
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <i class="fas fa-list my-green"></i> Surveys List 
            </div>
            
            <div class="panel-body">
                
                <table class="table table-striped tr-mid" id="overall_survey" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Source</th>
                            <th class="text-center">User Type</th>
                            <th class="text-center">Respondent</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Surveyed Date</th>                        
                        </tr>
                    </thead>
                    
                </table>
                
            </div>
            
        </div>

    </form>

    </div>

</div>

<?php 
include '../includes/footer.php';
include '../includes/scripts.php';
?>

<script src="<?=JS;?>autohide-alerts.js"></script>
<script src="<?=JS;?>moment.min.js"></script>
<script type="text/javascript">
$(document).ready(function () 
{
    // Start of Overall Table Data
    $('#overall_survey').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pagingType": "full_numbers",
        "responsive": true,
        "processing": true,  
		"ajax": {
	        "type": "POST",
	        "url": "/miaa/module/gender/lib/process_survey_list.php",
	        "dataSrc": function (data) 
		    {
                let overAllData = [];

                data.forEach(row => {
                    
                    overAllData.push({
                        "survey_id": `<input type="radio" id="survey_id" name="survey_id" class="gender-radio" value="${row.survey_id}">`,
                        "id": row.survey_id,
                        "source": row.sourcedesc,
                        "userType": row.user_typedesc,
                        "respondent": row.respondent,
                        "gender": row.gender,
                        "date": surveyStartEndDate(row.start_date,row.end_date)
                    });
                    
                });
				
			  	return overAllData;
			}
	    },
	    "columns": [
			{ "data": "survey_id" },
			{ "data": "id" },
			{ "data": "source" },
			{ "data": "userType" },
			{ "data": "respondent" },
			{ "data": "gender" },
			{ "data": "date" }
		]
	});
    // End of Overall Table Data

});

document.querySelector("#view_answers").addEventListener('click', (e) => {
    checkIfRadioButtonIsOn("survey_id", e);
});


</script>