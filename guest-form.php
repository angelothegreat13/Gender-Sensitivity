<?php 

require 'core/init.php';
include 'includes/styles.php';
include 'includes/plain_nav.php';

use Gender\Classes\GenderPreference;

use Gender\Classes\References\Settings\UserType;
use Gender\Classes\References\Settings\Source;

$source = new Source;
$user_type = new UserType;
$gender_pref = new GenderPreference;

auth_guard('restrict');

?>

<div class="container">

    <div class="col-md-5 col-centered mt-40">

        <div class="well well-md">

            <form action="<?=MODULE_URL;?>lib/process_guest_form.php" method="POST" id="guess-form">
                
                <div class="form-group mt-n-8">
                    <h3 class="my-header text-center">Guest Form</h3>
                </div>

                <div class="form-group inputWithLabelIcon">
                    <label for="firstname" class="clr-gry">First Name:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Optional" autocomplete="off">
                    <i class="fas fa-user icon"></i>
                </div>

                <div class="form-group inputWithLabelIcon">
                    <label for="lastname" class="clr-gry">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Optional" autocomplete="off">
                    <i class="fas fa-user icon"></i>
                </div>

                <div class="form-group inputWithLabelIcon">
                    <label for="gender" class="clr-gry">Gender:</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <i id="genderIcon" class="fas fa-male icon"></i>
                </div>

                <div class="form-group inputWithLabelIcon">
                    <label for="gender_pref" class="clr-gry">
                        Gender Preference: <a data-toggle="modal" href='#gender-pref-guide'><i class="fa fa-question-circle"></i></a>
                    </label> 
                    <select name="gender_pref" id="gender_pref" class="form-control">
                        <option value="">Select Gender Preference</option>
                        <?php foreach ($gender_pref->list() as $gender_pref_data) :?>
                        <option value="<?=$gender_pref_data->id;?>"><?=$gender_pref_data->genderdesc;?></option>
                        <?php endforeach;?>
                    </select>
                    <i class="fas fa-venus-mars icon"></i>
                </div>

                <div class="form-group inputWithLabelIcon">
                    <label for="userType" class="clr-gry">
                        User Type: <a data-toggle="modal" href='#user-type-guide'><i class="fa fa-question-circle"></i></a>
                    </label> 
                    <select name="userType" id="userType" class="form-control">
                        <option value="">Select a User Type</option>
                        <?php foreach ($user_type->bySource(2) as $user_type_data) :?>
                        <option value="<?php echo $user_type_data->id;?>"><?php echo $user_type_data->user_typedesc;?></option>
                        <?php endforeach;?>
                    </select>
                    <i class="fas fa-user-friends icon"></i>
                </div>

                <div class="checkbox text-center">
                    <label>
                        <input type="checkbox" class="my-checkbox" name="agree" id="agree" style="margin-top:3px;"> <strong class="ls-1">I have Read and Agree to MIAA's <a href="<?php echo MODULE_URL;?>terms-and-condition.php" target="_blank">Terms and Condition</a> and <a href="<?php echo MODULE_URL;?>privacy-policy.php" target="_blank">Privacy Policy</a></strong>
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" id="submit" class="btn my-btn btn-block" disabled> 
                        <i class="fas fa-play steel-blue"></i> Submit Form
                    </button>
                </div>

                <div class="form-group">
                    <a href="<?=MODULE_URL;?>login.php" class="btn my-btn btn-block" > 
                        <i class="fas fa-sign-in-alt my-green"></i> Go to User Login Form
                    </a>
                </div>

                <input type="hidden" name="token" value="<?php echo csrf_field();?>">

            </form>

        </div>

    </div>


    <!-- Gender Preference Guide -->
    <div class="modal fade" id="gender-pref-guide">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title my-green">Gender Preference Guide <i class="fa fa-info-circle steel-blue"></i></h4>
                </div>
                
                <div class="modal-body">
                    
                    <?php foreach ($gender_pref->list() as $gender_pref_data) :?>
                    <p class="clr-gry">
                        <i class="fas fa-circle jungle-green fs-13"></i>&nbsp; 
                        <strong class="ls-1"><?=$gender_pref_data->genderdesc;?></strong> - <?=$gender_pref_data->description;?>
                    </p>
                    <?php endforeach;?>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn my-btn" data-dismiss="modal">
                        <i class="fa fa-times radical-red"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>
    
    <!-- User Type Guide -->
    <div class="modal fade" id="user-type-guide">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title my-green">User Type Guide <i class="fa fa-info-circle steel-blue"></i></h4>
                </div>
                
                <div class="modal-body">
                    
                    <?php foreach ($user_type->bySource(2) as $user_type_data) :?>
                    <p class="clr-gry">
                        <i class="fas fa-play gamboge fs-13"></i>&nbsp; 
                        <strong class="ls-1"><?php echo $user_type_data->user_typedesc;?></strong> - <?php echo $user_type_data->description;?>
                    </p>
                    <?php endforeach;?>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn my-btn" data-dismiss="modal">
                        <i class="fa fa-times radical-red"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>
    
</div>

<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
<script src="<?=JS;?>jquery.validate.min.js"></script>
<script src="<?=JS;?>validate-help-block.js"></script>
<script type="text/javascript">

$("#gender").change(function () { 
    if ($(this).val() == "Male") {
        $("#genderIcon").addClass("fa-male").removeClass("fa-female");
    }
    else if($(this).val() == "Female") {
        $("#genderIcon").addClass("fa-female").removeClass("fa-male");
    }
});

$("#agree").click(function() {
    if($(this).prop("checked") == true) {
        $("#submit").removeAttr("disabled");
    }
    else if($(this).prop("checked") == false) {
        $("#submit").prop("disabled", true);
    }
});

$("#guess-form").validate({

    rules: {
        gender: "required",
        gender_pref: "required",
        userType: "required"
    },

    messages: {
        gender: {
            required: "Gender is required"
        },
        gender_pref: {
            required: "Gender Preference is required"
        },
        userType: {
            required: "User Type is required"
        }
    }

});

</script>


