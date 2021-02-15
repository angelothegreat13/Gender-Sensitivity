<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/plain_nav.php';
?>

<div class="container">

    <div class="col-md-5 col-centered mt-100">

        <div class="well well-md logout-container">

            <div class="col-md-12">
                <h3 class="red-header">ACCESS DENIED <i class="fas fa-door-closed"></i></h3>
                <p class="p-color">Please check username and password or maybe you are not allowed to access this systems.</p>
                <p><a href="<?php echo MODULE_URL;?>login.php">GO BACK TO LOGIN PAGE</a></p>
            </div>

        </div>

    </div>

</div>


<?php 
include 'includes/footer.php';
include 'includes/scripts.php';
?>