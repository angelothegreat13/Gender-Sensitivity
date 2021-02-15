<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/plain_nav.php';

auth_guard('restrict');

?>

<div class="container">

    <div class="col-md-5 col-centered mt-100">

        <div class="well well-md logout-container">

            <div class="col-md-12">
                <h3 class="red-header">LOGIN FAILED <i class="fas fa-exclamation-triangle"></i></h3>
                <p class="p-color">Please check your <strong>USERNAME</strong> and <strong>PASSWORD</strong> or maybe you are not allowed to access this system.</p>
                <p><a href="<?php echo MODULE_URL;?>login.php">GO BACK TO LOGIN PAGE</a></p>
            </div>

        </div>

    </div>

</div>

<?php 
include 'includes/footer.php';
include 'includes/scripts.php';
?>