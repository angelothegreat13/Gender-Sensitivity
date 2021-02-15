<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/plain_nav.php';

use Gender\Classes\Supports\Session;

auth_guard('restrict');

?>

<div class="container">

    <div class="col-md-5 col-centered mt-60">
        <?php Session::message();?>
        <div class="well well-md">

            <form action="<?php echo MODULE_URL;?>lib/login_exec.php" method="POST" id="login-form">

                <div class="form-group mt-n-8">
                    <h3 class="my-header text-center">Gender Sensitivity Login</h3>
                </div>
                
                <div class="form-group inputWithIcon">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    <i class="fas fa-user"></i>     
                </div>

                <div class="form-group inputWithIcon">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <i class="fas fa-lock"></i>     
                </div>

                <div class="form-group">
                    <button type="submit" class="btn my-btn btn-block"><i class="fas fa-sign-in-alt bell-flower"></i>   Login</button>
                </div>

                <input type="hidden" name="token" value="<?php echo csrf_field();?>">

                <div class="form-group text-center">
                    Want to take a survey Anonymously? <a href="<?php echo MODULE_URL;?>guest-form.php">Login as a Guest</a>
                </div>

            </form>

        </div>

    </div>

</div>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
<script type="text/javascript" src="<?php echo JS;?>jquery.validate.min.js"></script>
<script type="text/javascript">

$.validator.setDefaults({
    errorClass: 'help-block',
    highlight: function (element) {
        $(element)
            .closest('.form-group')
            .addClass('has-error');
    },

    unhighlight: function (element) {
        $(element)
            .closest('.form-group')
            .removeClass('has-error');
    }
});

$.validator.addMethod("nowhitespace", function (value, element) {
    return this.optional(element) || /^\S+$/i.test(value);
})

$("#login-form").validate({

    rules: {
        
        username: {
            required: true
        },

        password: {
            required: true,
            nowhitespace: true
        },

    },

    messages: {

        username: {
            required: "Username is required"
        },

        password: {
            required: "Password is required",
            nowhitespace: "No whitespace in password please"
        }

    }

});

</script>

