<?php 
require_once '../core/init.php';
include '../includes/styles.php';
include '../includes/navbar.php';

use Gender\Classes\UserAudit;
use Gender\Classes\References\Pds\PdsMain;
use Gender\Classes\Supports\Session;

auth_guard();

$user_audit = new UserAudit;
$pds = new PdsMain;

$user_audit->log(
    17, // Menu ID - Personal Data Sheet
    12 // Action ID - View
);

?>

<div class="container-fluid">

    <div class="col-md-12">
	<?php Session::message();?>

    	<form action="<?=MODULE_URL;?>lib/process_pds_tbl.php" method="POST">

		<div class="panel panel-default">
			<div class="panel-body">
				<div class="pull-right">
		            <button type="submit" name="view" id="view" class="btn my-btn mr-3">
		                <i class="fas fa-eye studio"></i> View
		            </button>
		            
		            <a href="<?=MODULE_URL;?>pds/add-pds.php" class="btn my-btn mr-3">
		                <i class="fas fa-plus picton-blue"></i> Add
		            </a>
		            
		            <button type="submit" name="edit" id="edit" class="btn my-btn mr-3">
		                <i class="fas fa-edit gamboge"></i> Edit
		            </button>
		            
		            <button type="button" name="delete" id="delete" class="btn my-btn mr-3">
		                <i class="fas fa-trash radical-red"></i> Delete
		            </button>
		            
		            <button type="button" name="restore" id="restore" class="btn my-btn">
		                <i class="fas fa-recycle jungle-green"></i> Restore
		            </button>
	        	</div>
			</div>
		</div>

		<div class="panel panel-default">

			<div class="panel-heading">
				<i class="far fa-id-card steel-blue"></i> Personal Data Sheets List
			</div>
			
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped tr-mid" id="pds-tbl" width="100%">
						<thead>
							<tr>
								<th class="text-center"></th>
								<th class="text-center">ID</th>
								<th class="text-center">Photo</th>
								<th class="text-center">Full Name</th>
								<th class="text-center">Pds Type</th>
								<th class="text-center">Status</th>
								<th class="text-center">Date Created</th>
							</tr>
						</thead>
						
					</table>
				</div>
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
<script type="text/javascript">

const URL = "/miaa/module/gender/lib/";

$(document).ready(function () {

	$("#pds-tbl").DataTable({
        "pagingType": "full_numbers",
        "responsive": true,
        "processing": true,
        "serverSide":true,
        "pageLength": 10,
        "cache": false,
        "order": [[ 0, "DESC" ]],
        "ajax":{
            url: URL + "load_pds_tbl.php",
            type:"POST",
            dataType: "JSON"
        },
        "columnDefs":[
            {
                "targets":[0,2],
                "orderable":false,
            },
        ]
    });
	
});
	
document.getElementById("view").addEventListener("click", (e) => {
    checkIfRadioButtonIsOn("pds_id", e);
});

document.getElementById("edit").addEventListener("click", (e) => {
    checkIfRadioButtonIsOn("pds_id", e);
});


$("body").on("click", "#delete", function() {

	let pdsID = $("input[name='pds_id']:checked").val();

    if (pdsID == null) {
        displayError("Please Select a Radio Button");
    } 
    else {
        alertify.confirm('Confirm Delete', '<label class="text-info"><i class="fas fa-info"></i>&nbsp; Are you sure you want to delete this PDS?</label>',
            () => {
                $.ajax({
                    url: URL + "delete_pds.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {pds_id : pdsID},
                    success: function(res) {   
                        if (res == "success") { 
                            setTimeout(() => { window.location.reload(); }, 100);
                        }
                    }
                });
            },() => {  });
    }

    return false;
});


$("body").on("click","#restore",function () 
{
    let pdsID = $("input[name='pds_id']:checked").val();

    if (pdsID == null) {
        displayError("Please Select a Radio Button");
    } 
    else {
        $.ajax({
            url: URL + "restore_pds.php",
            type: "POST",
            dataType: "JSON",
            data: {pds_id : pdsID},
            success: function(res) {   
                if (res == "success") { 
                    setTimeout(() => { window.location.reload(); }, 100);
                }
            }
        });
    }
});

</script>

