<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/plain_nav.php';

use Gender\Classes\LoginHistory;
use Gender\Classes\UserAudit;

use Gender\Classes\Supports\Session;    
use Gender\Classes\Supports\Redirect;

$login_history = new LoginHistory;
$user_audit = new UserAudit;

if (validate_session('SESS_GENDER_USER_LOGIN_HISTORY_ID')) {
    
    $login_history->update(Session::get('SESS_GENDER_USER_LOGIN_HISTORY_ID'),[
        'logout_date' => dateNow()
    ]);

    $user_audit->log(
        16, // Menu ID - Logout Form
        2 // Action ID - Logout
    );

    session_destroy_forever();
}


?>

<div class="container">

    <div class="col-md-5 col-centered mt-100">

        <div class="well well-md logout-container">

            <div class="col-md-12">
                <h3 class="red-header">SYSTEM LOGOUT <i class="fas fa-sign-out-alt"></i></h3>
                <p class="quotes">"If you're brave enough to say goodbye, life will reward you with a new hello." - <strong>Paulo Coelho</strong></p>
                <p><a href="<?php echo MODULE_URL;?>login.php">GO BACK TO LOGIN PAGE</a></p>
            </div>

        </div>

    </div>

</div>


<?php 
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>