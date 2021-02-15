<?php 

require 'core/init.php';
include 'includes/styles.php';
include 'includes/plain_nav.php';

use Gender\Classes\References\Settings\Group;
use Gender\Classes\References\Settings\Source;
use Gender\Classes\References\Settings\UserType;
use Gender\Classes\References\Terms\Suffix;

$group = new Group;
$suffix = new Suffix;
$source = new Source;
$user_type = new UserType;

?>
<link rel="stylesheet" href="<?=JS;?>intl-tel-input-master/build/css/intlTelInput.min.css">

<div class="container">

    <div class="col-md-6 col-md-offset-3 mt-40">

        <div class="well well-md">

            <form action="<?=MODULE_URL;?>lib/process_user_reg_form.php" method="POST" id="user-registration-form">
                
                <div class="form-group mt-n-8">
                    <h3 class="my-header text-center">User Registration</h3>
                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="firstname" class="clr-gry">Source:</label>
                            <select name="" id="" class="form-control">
                                <option value="">Internal</option>
                                <option value="">External</option>
                            </select>
                        </div>
                    
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="lastname" class="clr-gry">UserType:</label>
                            <select name="" id="" class="form-control">
                                <option value="">Employee</option>
                                <option value="">Visitor</option>
                            </select>
                        </div>
                    
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="firstname" class="clr-gry">First Name:</label>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                        </div>
                    
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="lastname" class="clr-gry">Last Name:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                    
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="middlename" class="clr-gry">Middle Name:</label>
                            <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Full Middle Name (optional)">
                        </div>
                    
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="suffix" class="clr-gry">Suffix:</label>
                            <select name="suffix" id="suffix" class="form-control">
                                <option value="">Select a Suffix</option>
                                <?php foreach ($suffix->list() as $suffix_data):?>
                                <option value="<?=$suffix_data->suffixdesc;?>"><?=$suffix_data->suffixdesc;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    
                    </div>
                
                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="username" class="clr-gry">Email Address:</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="phoneNumber" class="clr-gry">Phone Number:</label>                            
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber">
                            <label id="phone-num-error" class="hide"></label>
                        </div>
                    
                    </div>
                
                </div>

                <div class="row">
                
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="group" class="clr-gry">Group:</label>
                            <select name="group" id="group" class="form-control">
                                <option value="">Group</option>
                                <?php foreach ($group->list() as $group_data) :?>
                                <option value="<?=$group_data->id;?>"><?=$group_data->groupdesc;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="username" class="clr-gry">Username:</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                    
                    </div>

                </div>

                <div class="row">
                
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="password" class="clr-gry">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="confirm-pass" class="clr-gry">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm-pass" name="confirm-pass">
                        </div>
                    
                    </div>
                
                </div>

                <div class="form-group">
                    <button type="submit" class="btn my-btn"><i class="fas fa-play bell-flower"></i> Submit Form</button>
                </div>

            </form>

        </div>

    </div>

</div>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
<script src="<?=JS;?>jquery.validate.min.js"></script>
<script src="<?=JS;?>intl-tel-input-master/build/js/intlTelInput.min.js"></script>
<script type="text/javascript">

// Start of User Registration Form Validation
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
}),

$("#user-registration-form").validate({

    rules: {

        firstname: {
            required: true
        },
        username: {
            required: true
        },
        password: {
            required: true,
            nowhitespace: true
        }

    },

    messages: {

        firstname: {
            required: "Firstname is required"
        },
        username: {
            required: "Username is required"
        },
        password: {
            required: "Password is required",
            nowhitespace: "No whitespace in password please"
        }

    }

});
// End of User Registration Form Validation


// Custom Validation for Contact Number
const phoneNum = document.querySelector("#phoneNumber");
const phoneNumError = document.querySelector("#phone-num-error");
const userRegistrationForm = document.querySelector("#user-registration-form");

let errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise intelInput plugin
const initPhoneNum = window.intlTelInput(phoneNum, {
    preferredCountries: ["ph"],
    utilsScript:"../../../miaa/assets/js/intl-tel-input-master/build/js/utils.js"
});

const validatePhoneNumber = (e) => {
    if (phoneNum.value.trim()) {
        if (initPhoneNum.isValidNumber()) {
            phoneNumError.classList.remove("hide");
            phoneNumError.classList.add("hide");
        } 
        else {
            phoneNumError.innerHTML = errorMap[initPhoneNum.getValidationError()];
            phoneNumError.classList.remove("hide");
            e.preventDefault();
        }
    }
    else if(phoneNum.value == "") {
        phoneNumError.innerHTML = "Phone Number is required";
        phoneNumError.classList.remove("hide");
        e.preventDefault();
    }
};

phoneNum.addEventListener('change', validatePhoneNumber); // blur 
userRegistrationForm.addEventListener("submit",validatePhoneNumber);

</script>

