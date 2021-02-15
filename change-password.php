<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/navbar.php';

use Gender\Classes\Supports\Session;
use Gender\Classes\UserAudit;

auth_guard();

$user_audit = new UserAudit;

$user_audit->log(
    14, // Menu ID - Change Password
    12 // Action ID - View
);


?>

<link rel="stylesheet" href="<?=JS;?>tipso/src/tipso.css">

<div class="container">

    <div class="col-md-5 col-centered mt-50">
        <?php Session::message();?>
        
        <form action="<?=MODULE_URL;?>lib/change_user_pass.php" method="POST" id="change-pass-form">
        
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <i class="fas fa-user-lock bell-flower"></i> Change Password
            </div>
            
            <div class="panel-body">
                
                <div class="form-group">
                    <label for="currentPassword" class="clr-gry">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="newPassword" class="clr-gry">New Password</label> 
                    <span class="pass-guide"><i class="fa fa-info-circle picton-blue"></i></span>
                    <input type="password" class="form-control disabled-tag" id="newPassword" name="newPassword" disabled>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="clr-gry">Confirm Password</label>
                    <input type="password" class="form-control disabled-tag" id="confirmPassword" name="confirmPassword" disabled>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn my-btn disabled-tag" disabled><i class="fas fa-pen-alt steel-blue"></i> Update Password</button>
                </div>

            </div>

        </div>

        <input type="hidden" name="token" value="<?=csrf_field();?>">
        
        </form>

    </div>

</div>


<?php 
include 'includes/footer.php';
include 'includes/scripts.php';
?>

<script type="text/javascript" src="<?=JS;?>jquery.validate.min.js"></script>
<script src="<?=JS;?>validate-help-block.js"></script>
<script src="<?=JS;?>tipso/src/tipso.js"></script>
<script src="<?=JS;?>tipso-pass-guide.js"></script>
<script type="text/javascript">

$.validator.addMethod("nowhitespace", function (value, element) {
    return this.optional(element) || /^\S+$/i.test(value);
}),

$.validator.addMethod("lowerCase", function (value, element) {
    return this.optional(element) || /(?=.*?[a-z])/.test(value);
}),

$.validator.addMethod("upperCase", function (value, element) {
    return this.optional(element) || /(?=.*?[A-Z])/.test(value);
}),

$.validator.addMethod("numeric", function (value, element) {
    return this.optional(element) || /(?=.*?[0-9])/.test(value);
}),

$.validator.addMethod("specialCharacter", function (value, element) {
    return this.optional(element) || /(?=.*?[#?!@$%^&*-])/.test(value);
})

$("#change-pass-form").validate({

    rules: {
        
        currentPassword: "required",

        newPassword: {
            required: true,
            minlength: 6,
            maxlength: 16,
            nowhitespace: true,
            lowerCase: true,
            upperCase: true,
            numeric: true,
            specialCharacter: true
        },

        confirmPassword: {
            required: true,
            equalTo: '#newPassword'
        },

    },

    messages: {

        currentPassword: {
            required: "Current Password is required"
        },

        newPassword: {
            required: "New Password is required",
            nowhitespace: "No whitespace in password please",
            lowerCase: "Please enter at least one lower case letter",
            upperCase: "Please enter at least one upper case letter",
            numeric: "Please enter at least one number",
            specialCharacter: "Please enter at least one special character"
        },

        confirmPassword: {
            required: "Confirm Password is required",
            equalTo: "The Password and Confirm Password do not match"
        }

    }

});

const currentPass = document.getElementById("currentPassword");
const disabledTag = document.querySelectorAll(".disabled-tag");

const setDisabledTag = (status) => {

    disabledTag.forEach(element => {
        element.disabled = status;
    });

};

const checkIfCurrentPasswordExists = () => {

    fetch("/miaa/module/gender/lib/check_current_pass.php",{
        method: "POST",
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-type':'application/json'
        },
        body:JSON.stringify({
            current_pass: currentPass.value
        })
    })
    .then((res) => res.json())
    .then((res) => {
        setDisabledTag()
        if (res) {
           setDisabledTag(false);
        }
        else {
           setDisabledTag(true);
        }
    });

};

currentPass.addEventListener("keyup",checkIfCurrentPasswordExists);

</script>