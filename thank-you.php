<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/navbar.php';

use Gender\Classes\Supports\Redirect;   

if (!validate_session('thank-you')) {
    Redirect::to('guest-form');
}

?>

<div class="container">

    <div class="col-md-6 col-md-offset-3 mt-100">

        <div class="well well-lg">
            <div class="text-center">
                <h2 class="jungle-green ls-1">Thank you for Answering the Survey <i class="far fa-smile-beam gamboge"></i></h2>
                <p class="my-header">You're the best!</p>
                <form action="<?php echo MODULE_URL;?>lib/guest_logout.php" method="POST">
                    
                    <button type="submit" name="survey_again" class="no-underline fw-6 picton-blue ls-1 transparent-btn">
                        <i class="fas fa-poll bell-flower"></i> Take a Survey Again 
                    </button>        
            
                    <button type="submit" name="logout" class="no-underline fw-6 picton-blue ls-1 transparent-btn">
                        <i class="fas fa-sign-out-alt radical-red"></i> Logout
                    </button>

                    <input type="hidden" name="token" value="<?php echo csrf_field();?>">
                </form>
            </div>
        </div>
    
    </div>

</div>

<?php 
include 'includes/scripts.php';
include 'includes/footer.php';
?>