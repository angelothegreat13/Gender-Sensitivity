<?php 
require_once 'core/init.php';
include 'includes/styles.php';
include 'includes/navbar.php';

use Gender\Classes\User;
use Gender\Classes\UserAudit;

auth_guard();

$user = new User;
$user_audit = new UserAudit;

$user_data = $user->data();

$user_audit->log(
    9, // Menu ID - Account Information
    12 // Action ID - View
);

?>


<div class="container-fluid">

    <div class="col-md-4 col-centered mt-50">

        <div class="well well-md">

            <h3 class="text-center my-header uppercase">Account Information <i class="far fa-user steel-blue"></i></h3><br>

            <div class="form-group">
                <label class="clr-gry">First Name:</label>
                <input type="text" class="form-control" value="<?=$user_data->firstname;?>" readonly>
            </div>

            <div class="form-group">
                <label class="clr-gry">Last Name:</label>
                <input type="text" class="form-control" value="<?=$user_data->lastname;?>" readonly>
            </div>

            <div class="form-group">
                <label class="clr-gry">Gender:</label>
                <input type="text" class="form-control" value="<?=$user_data->gender;?>" readonly>
            </div>

            <div class="form-group">
                <label class="clr-gry">Office:</label>
                <input type="text" class="form-control" value="<?=none($user_data->offdesc);?>" readonly>
            </div>

            <div class="form-group">
                <label class="clr-gry">Department:</label>
                <input type="text" class="form-control" value="<?=if_null($user_data->deptdesc,'None');?>" readonly>
            </div>

            <div class="form-group">
                <label class="clr-gry">Division:</label>
                <input type="text" class="form-control" value="<?=if_null($user_data->divdesc,'None');?>" readonly>
            </div>
            
        </div>

    </div>

</div>


<?php 
include 'includes/scripts.php';
include 'includes/footer.php';
?>