<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/navbar.php';  

use Carbon\Carbon;
use Gender\Classes\LoginHistory;
use Gender\Classes\UserAudit;
use Gender\Classes\Supports\Session;

auth_guard();

$login_history = new LoginHistory;
$user_audit = new UserAudit;

$user_audit->log(
    15, // Menu ID - Login History Table
    12 // Action ID - View
);

?>

<div class="container-fluid">

    <div class="col-md-12">

        <div class="panel panel-default">
            
            <div class="panel-heading">
                <i class="fas fa-user-clock hanada"></i> User Login History
            </div>
            
            <div class="panel-body">

                <table class="table table-striped" id="login_history_tbl" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Browser</th>
                            <th class="text-center">Platform</th>
                            <th class="text-center">Login Date</th>
                            <th class="text-center">Logout Date</th>
                            <th class="text-center">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($login_history->byUser(Session::get('SESS_GENDER_USER_ID')) as $data): 
                        $logout = Carbon::parse($data->logout_date);
                        $duration = $logout->diffForHumans($data->login_date); 
                        ?>
                        <tr class="text-center">
                            <td><?php echo $i++;?></td>
                            <td><?php echo $data->browser;?></td>
                            <td><?php echo $data->platform;?></td>
                            <td><?php echo pretty_date($data->login_date);?></td>
                            <td><?php echo logout_date($data->logout_date);?></td>
                            <td><?php echo $duration;?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                
            </div>
            
        </div>
    
    </div>

</div>

<?php 
include 'includes/scripts.php';
include 'includes/footer.php';
?>
<script type="text/javascript">
$(document).ready(function () 
{
    $('#login_history_tbl').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pagingType: "full_numbers",
        responsive: true
    });
});
</script>