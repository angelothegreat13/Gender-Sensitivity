<?php 
require 'core/init.php';
require 'includes/styles.php';
require 'includes/navbar.php';

use Gender\Classes\Supports\Session;
use Gender\Classes\Employee;

auth_guard();

Session::message();

?>

<div class="my-container">

    <form action="pds.php" method="POST">
            
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="pull-right">
                    <button type="submit" name="view_pds_btn" id="view_pds_btn" class="btn my-btn">
                        <i class="fa fa-eye picton-blue"></i> View
                    </button>
                    <button type="submit" name="add_pds_btn" id="add_pds_btn" class="btn my-btn">
                        <i class="fa fa-plus my-green"></i> Create
                    </button>
                    <button type="submit" name="edit_pds_btn" id="edit_pds_btn" class="btn my-btn">
                        <i class="fa fa-edit gamboge"></i> Edit
                    </button>
                    <button type="submit" name="delete_pds_btn" id="delete_pds_btn" class="btn my-btn">
                        <i class="fa fa-trash radical-red"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-list gamboge" aria-hidden="true"></i> List of Personal Data Sheets
            </div>
            <div class="panel-body">
                <table class="table table-striped" id="emp_list" style="width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center">Employee ID</th>
                            <th class="text-center">Employee Photo</th>
                            <th class="text-center">Employee Name</th>
                            <th class="text-center">Position</th>
                            <th class="text-center">Office</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $employee = new Employee;
                        foreach($employee -> partialData() as $data): ?>
                        <tr class="text-center">
                            <td>
                                <input type="radio" id="empno" name="empno" class="gender-radio" value="<?php echo $data -> empno;?>">
                            </td>
                            <td><?php echo $data -> empno;?></td>
                            <td><img src="<?php echo personImage($data -> photo,$data -> sex);?>" height="50" width="50" class="img-circle"></td>
                            <td><?php echo $data -> employeeFullName;?></td>
                            <td><?php echo $data -> posndesc;?></td>
                            <td><?php echo $data -> offdesc;?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

</div>

<?php 
include 'includes/scripts.php';
include 'includes/footer.php';?>
<script src="/miaa/assets/js/gender/main-pds.js"></script>
<script type="text/javascript">
$(document).ready(function () 
{
    $('#emp_list').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pagingType: "full_numbers",
        responsive: true
    });
});

$('#edit_pds_btn').click(checkIfPdsRadioButtonIsClicked);

$('#delete_pds_btn').click(checkIfPdsRadioButtonIsClicked);

$('#view_pds_btn').click(checkIfPdsRadioButtonIsClicked);
</script>