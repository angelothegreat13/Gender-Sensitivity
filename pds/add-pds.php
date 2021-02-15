<?php 
require '../core/init.php';
include '../includes/styles.php';
include '../includes/navbar.php';

auth_guard();

use Gender\Classes\PDS;
use Gender\Classes\Address;
use Gender\Classes\Organization;
use Gender\Classes\GenderPreference;
use Gender\Classes\UserAudit;

use Gender\Classes\References\Terms\Prefix;
use Gender\Classes\References\Terms\Suffix;
use Gender\Classes\References\Terms\BloodType;
use Gender\Classes\References\Terms\CivilStatus;
use Gender\Classes\References\Terms\Religion;
use Gender\Classes\References\Terms\Country;
use Gender\Classes\References\Terms\Position;
use Gender\Classes\References\Terms\PhysicalStatus;
use Gender\Classes\References\Terms\CareerService;
use Gender\Classes\References\Terms\EmploymentType;

use Gender\Classes\References\Settings\UserType;
use Gender\Classes\References\Settings\Source;

use Gender\Classes\References\Address\Region;

use Gender\Classes\References\Organizations\Office;
use Gender\Classes\References\Organizations\OrganizationType;

$user_type = new UserType;
$prefix = new Prefix;
$suffix = new Suffix;
$blood_type = new BloodType;
$gender_pref = new GenderPreference;
$civil_status = new CivilStatus;
$religion = new Religion;
$country = new Country;
$position = new Position;
$office = new Office;
$region = new Region;
$physical_status = new PhysicalStatus;
$career_service = new CareerService;
$source = new Source;
$emp_type = new EmploymentType;
$org_type = new OrganizationType;
$user_audit = new UserAudit;

$user_audit->log(
    17, // Menu ID - Personal Data Sheet
    12 // Action ID - View
);
?>

<link rel="stylesheet" href="<?=JS;?>intl-tel-input-master/build/css/intlTelInput.min.css">
<link rel="stylesheet" href="<?=ASSETS;?>templates/AdminLTE-master/bower_components/select2/dist/css/select2.min.css">

<div class="container-fluid">

    <div class="col-md-12">
    
    <form action="<?=MODULE_URL;?>lib/store_pds.php" method="POST" enctype="multipart/form-data" id="pds_form">
        
        <div class="well well-md text-right">
            <div class="form-inline">
                <div class="form-group">
                    <span class="data-entry-msg mr-3">Do you want to add this record?</span>
                </div>
                <button type="submit" id="save_pds_btn" name="save_pds_btn" class="btn my-btn mr-3">
                	<i class="fa fa-check my-green"></i> OK
                </button>
				<a href="<?=MODULE_URL;?>pds/pds-list.php" class="btn my-btn">
					<i class="fa fa-times radical-red"></i> CANCEL
				</a>
            </div>
        </div>
        
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <img src="<?=IMAGES;?>add_user.svg" class="mini-icon"> PDS Data Entry
            </div>
            
            <div class="panel-body">
                
                <div class="form-horizontal">

                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12 pds-top">
                                    <select id="prefix" name="prefix" class="form-control">
                                        <option value="">Prefixes</option>
                                        <?php foreach ($prefix->list() as $prefix_data) :?>
                                        <option value="<?=$prefix_data->prefixdesc;?>"><?=$prefix_data->prefixdesc;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12 pds-top">
						            <input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12 pds-top">
						            <input type="text" id="fname" name="fname" class="form-control" placeholder="First Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12 pds-top">
						            <input type="text" id="mname" name="mname" class="form-control" placeholder="Middle Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
						            <select id="suffix" name="suffix" class="form-control">
                                        <option value="">Suffixes</option>
                                        <?php foreach ($suffix->list() as $suffix_data) :?>
                                        <option value="<?=$suffix_data->suffixdesc;?>"><?=$suffix_data->suffixdesc;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                    	<a href="#information" aria-controls="information" role="tab" data-toggle="tab">INFORMATION</a>
                    </li>
                    <li role="presentation">
                    	<a href="#address" aria-controls="address" role="tab" data-toggle="tab">ADDRESS</a>
                    </li>
                    <li role="presentation">
                    	<a href="#family" aria-controls="family" role="tab" data-toggle="tab">FAMILY</a>
                    </li>
                    <li role="presentation">
                    	<a href="#children" aria-controls="children" role="tab" data-toggle="tab">CHILDREN</a>
                    </li>
                    <li role="presentation">
                    	<a href="#education" aria-controls="education" role="tab" data-toggle="tab">EDUCATION</a>
                    </li>
                    <li role="presentation">
                    	<a href="#trainings" aria-controls="trainings" role="tab" data-toggle="tab">TRAINING</a>
                    </li>
                    <li role="presentation">
                    	<a href="#eligibility" aria-controls="eligibility" role="tab" data-toggle="tab">ELIGIBILITY</a>
                    </li>
                    <!-- <li role="presentation">
                    	<a href="#medical" aria-controls="medical" role="tab" data-toggle="tab">MEDICAL</a>
                    </li> -->
                    <li role="presentation">
                    	<a href="#organization" aria-controls="organization" role="tab" data-toggle="tab">ORGANIZATION</a>
                    </li>
                </ul><br>

                <div class="tab-content">


                    <!-- Information Tab -->
                    <div role="tabpanel" class="tab-pane fade in active" id="information">
                        
                        <div class="row">

                        	<!-- Start of Personal Information Tab -->
                            <div class="col-md-6">

                                <div class="personal-information-form">

                                    <div class="alert pds-tab personal-tab-bg-color" role="alert">
                                        <i class="fa fa-user" aria-hidden="true"></i> Personal Information
                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-12">
                                    		 <div class="form-group text-center">
    		                                    <img class="img-circle" src="<?=IMAGES;?>user.svg" width="150" height="150" id="person_img">
                            					<input type="hidden" name="person_blob_img" id="person_blob_img">
    		                                </div>

    		                                <div class="form-group text-center">
    		                                    <label class="btn my-btn mr-3">
    		                                    	<i class="far fa-file-image gamboge" aria-hidden="true"></i> Browse 
    		                                    	<input type="file" style="display: none;" id="person_pic_input" onchange="readImgURL(this,'person_img');" accept="image/x-png, image/gif, image/jpeg">
    		                                    </label>
    		                                    <button type="button" id="webcam-button" class="btn my-btn mr-3">
    		                                    	<i class="fa fa-camera-retro hanada" aria-hidden="true"></i>  Webcam
    		                                    </button>
    		                                </div>   
                                    	</div>

                                    </div>

                                    <div class="row">
                
                                        <input type="hidden" id="source" name="source">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pds_type">PDS Type:</label>
                                                <select id="pds_type" name="pds_type" class="form-control">
                                                    <option value="">PDS Types List:</option>	
                                                    <?php foreach ($user_type->list() as $user_type_data) :?>
                                                    <option value="<?=$user_type_data->id;?>"><?=$user_type_data->user_typedesc;?></option>
                                                    <?php endforeach;?>
						                        </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group cor-id-group">
                                                <label class="cor-id-label" for="select_input_id">Corresponding ID:</label> 
                                                <small class="pds-type-first-sm">(Select PDS type first)</small>
                                                <select name="select_input_id" id="select_input_id" class="form-control select-input-id select2-input-tag" style="width:100%;">
                                                </select>
                                                <div id="input-id-error"></div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-4">
                                    		<div class="form-group">
                                                <label for="height">Height (m):</label>
                                                <input type="number" class="form-control" id="height" name="height" min="0">
                                            </div>
                                    	</div>
                                    	
                                    	<div class="col-md-4">
                                    		<div class="form-group">
                                                <label for="weight">Weight (kg):</label>
                                                <input type="number" class="form-control" id="weight" name="weight" min="0">
                                            </div>
                                    	</div>
    									
    									<div class="col-md-4">
    										<div class="form-group">
                                                <label for="blood_type">Blood Type:</label>
                                                <select name="blood_type" id="blood_type" class="form-control">
                                                    <option value="">Blood Type</option>
                                                    <?php foreach ($blood_type->list() as $blood_type_data) :?>
                                                    <option value="<?=$blood_type_data->bloodtypedesc;?>"><?=$blood_type_data->bloodtypedesc;?></option>
                                                	<?php endforeach;?>
                                                </select>
                                            </div>
    									</div>
                                    
                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender">Gender:</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="">Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                        	<div class="form-group">
                                        		<label for="organization">Gender Preference:</label>
                                                <select name="gender_pref" id="gender_pref" class="form-control">
                                                    <option value="">Gender Preferences</option>
                                                    <?php foreach ($gender_pref->list() as $genderpref_data) :?>
                                                        <option value="<?=$genderpref_data->id;?>"><?=$genderpref_data->genderdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                        	</div>
                                        </div>

                                        <div class="col-md-4">
                                        	<div class="form-group">
                                                <label for="civil_status">Civil Status:</label>
                                                <select name="civil_status" id="civil_status" class="form-control">
                                                    <option value="">Select Civil Status</option>
                                                    <?php foreach ($civil_status->list() as $civil_status_data) :?>
                                                    <option value="<?=$civil_status_data->civilstatusdesc;?>"><?=$civil_status_data->civilstatusdesc;?></option>
                                                	<?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                    	<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bday">Birthday:</label>
                                                <input type="text" class="form-control" id="bday" name="bday">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                        	<div class="form-group">
                                                <label for="pob">Place of Birth:</label>
                                                <input type="text" class="form-control" id="pob" name="pob">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="nationality">Nationality: </label>
                                                <select id="nationality" name="nationality" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">List of Nationalities</option>
                                                    <?php foreach ($country->list() as $country_data) :?>
                                                    <option value="<?=$country_data->country_enNationality;?>"><?=$country_data->country_enNationality;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="religion">Religion:</label>
                                                <select class="form-control" id="religion" name="religion">
    												<option value="">Select a Religion</option>
    												<?php foreach ($religion->list() as $religion_data) :?>
    												<option value="<?=$religion_data->religiondesc;?>"><?=$religion_data->religiondesc;?></option>
    												<?php endforeach;?>
                                                </select>
                                            </div>
                                    	</div>

                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="phone">Phone Number:</label>
                                                <input type="hidden" name="cp_country_code" id="cp_country_code">
                                                <input type="text" class="form-control" id="phone" name="phone"> 
                                                <label id="phone-num-error" class="hide"></label> 
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="telephone">Telephone Number: </label>
                                                <input type="number" class="form-control" id="telephone" name="telephone" min="0">
                                            </div>
                                    	</div>

                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="email">Email Address: </label>
                                                <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="employment_type">Employment Type:</label>
                                                <select name="employment_type" id="employment_type" class="form-control">
                                                    <option value="">Employment Types</option>
                                                    <?php foreach ($emp_type->list() as $emp_type_data) :?>
                                                        <option value="<?=$emp_type_data->typecode;?>">
                                                            <?=$emp_type_data->typedesc;?>
                                                        </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="position">Position: </label>
                                                <select name="position" id="position" class="form-control" style="width: 100%;">
                                                    <option value="">Positions List</option>
                                                    <?php foreach ($position->list() as $position_data) :?>
                                                    <option value="<?=$position_data->posncode;?>"><?=$position_data->posndesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <!-- Start of Webcam Modal -->
							    <div class="modal fade" id="webcam-modal" tabindex="-1" role="dialog" aria-labelledby="webcam-modalLabel">
							        <div class="modal-dialog modal-lg" role="document">
							            <div class="modal-content">
    							            <div class="modal-body">
    							                
    							                <div class="row">
    							                
    							                    <div class="col-md-8">
    							                        
    							                        <div class="alert custom-tab bg-jp-yellow" role="alert">
    							                            <i class="fas fa-video"></i> Webcam Video
    							                        </div>

    							                        <video id="video" autoplay="autoplay" class="img-responsive"></video>
    							                    </div>

    							                    <div class="col-md-4">

    							                        <div class="alert custom-tab bg-ultra-marine" role="alert">
    							                            <i class="fas fa-image"></i> Preview Image
    							                        </div>

    							                        <div class="form-group">
    							                            <img src="<?=IMAGES;?>image-preview.png" id="webcam_preview_img" class="img-responsive" alt="preview">
    							                        </div>

    							                        <div class="form-group">
    							                            <button type="button" id="buttonSnap" class="btn my-btn-lg btn-block" onclick="snapshot()">
    							                                <i class="fa fa-camera gamboge" aria-hidden="true"></i> Take Snapshot
    							                            </button>
    							                            <button type="button" class="btn my-btn-lg btn-block" onclick="saveWebcamImg()">
    							                                <i class="fas fa-save steel-blue"></i> Save Image
    							                            </button>
    							                            <button type="button" class="btn my-btn-lg btn-block" data-dismiss="modal" onclick="stopWebcam()">
    							                                <i class="fa fa-times radical-red" aria-hidden="true"></i> Close
    							                            </button>
    							                        </div>
    							                        
    							                    </div>
    							                    
    							                    <input type="hidden" name="webcam_img" id="webcam_img">
    							                    <canvas id="webcam_canvas" style="display:none;"></canvas>
    							                </div>
    							                
    							            </div>
							            </div>
							        </div>
							    </div>
							    <!-- End of Webcam Modal -->

                            </div>
                        	<!-- End of Personal Information Tab -->


                            <div class="col-md-6">

                                <!-- Start of MIAA Organizations Tab -->
                                <div class="miaa-org-form">

                                    <div class="alert pds-tab offices-tab-bg-color" role="alert">
                                        <i class="fas fa-briefcase"></i> MIAA ORGANIZATIONS
                                    </div>

                                    <div class="form-horizontal">
                
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="office" class="col-sm-2 control-label">Office:</label>
                                                    <div class="col-sm-10">
                                                    <select name="office" id="office" class="form-control">
                                                        <option value="">List of Offices</option>
                                                        <?php foreach($office->list() as $office_data):?>
                                                        <option value="<?=$office_data->offcode;?>"><?=$office_data->offdesc;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="department" class="col-sm-2 control-label">Department:</label>
                                                    <div class="col-sm-10">
                                                    <select name="department" id="department" class="form-control">
                                                        <option value="">List of Departments</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="division" class="col-sm-2 control-label">Division:</label>
                                                    <div class="col-sm-10">
                                                    <select name="division" id="division" class="form-control">
                                                        <option value="">List of Divisions</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        
                                    </div>

                                </div>
                                <!-- End of MIAA Organizations Tab -->


                                <!-- Start of Government Credentials -->
                                <br>
                                <div class="gov-credentials-form">

                                    <div class="alert pds-tab goverment-person-tab-bg-color" role="alert">
                                        <i class="fas fa-building"></i> Government Credentials
                                    </div>
    
                                    <div class="row">

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="gsis">GSIS ID NO: </label>
                                                <input type="text" class="form-control" id="gsis" name="gsis">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="pagibig">PAGIBIG ID NO: </label>
                                                <input type="text" class="form-control" id="pagibig" name="pagibig">
                                            </div>
                                    	</div>

                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="philhealth">PHILHEALTH NO: </label>
                                                <input type="text" class="form-control" id="philhealth" name="philhealth">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="sss">SSS NO: </label>
                                                <input type="text" class="form-control" id="sss" name="sss">
                                            </div>
                                    	</div>
                                    
                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="tin">TIN NO: </label>
                                                <input type="text" class="form-control" id="tin" name="tin">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="voter_id_num">VOTER ID NO: </label>
                                                <input type="text" class="form-control" id="voter_id_num" name="voter_id_num">
                                            </div>
                                    	</div>

                                    </div>
            
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="csc_id_num">CSC ID NO: </label>
                                                <input type="text" class="form-control" id="csc_id_num" name="csc_id_num">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nbi_id_num">NBI ID NO: </label>
                                                <input type="text" class="form-control" id="nbi_id_num" name="nbi_id_num">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!-- End of Government Credentials -->


                                <!-- Start of Contact Person Information -->
                                <br>
                                <div class="contact-person-info-form">

                                    <div class="alert pds-tab contact-person-tab-bg-color" role="alert">
                                        <i class="fa fa-phone" aria-hidden="true"></i> Contact Person Information
                                    </div>
                                
                                    <div class="row">
                                    	
                                    	<div class="col-md-12">
                                    		<div class="form-group">
                                                <label for="cpname">Name:</label>
                                    			<input type="text" class="form-control" id="cpname" name="cpname">
                                    		</div>
                                    	</div>
                                    
                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="cprelationship">Relationship: </label>
                                                <input type="text" class="form-control" id="cprelationship" name="cprelationship">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="cpcontactnum">Contact Number: </label>
                                                <input type="number" class="form-control" id="cpcontactnum" name="cpcontactnum" min="0">
                                            </div>
                                    	</div>
                                    
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <!-- End of Information Tab -->


                    <!-- Start of Address Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="address">
                        
                        <div class="row">
                                
                            <!-- Start of Residental Address -->
                            <div class="col-md-6">

                                <div class="residential-address-form">

                                    <div class="alert pds-tab residential-address-tab-bg-color" role="alert">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i> Residential Address
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="res_room_num">Unit/Room No. Floor:</label>
                                                <input type="text" name="res_room_num" id="res_room_num" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_building_name">Building Name:</label>
                                                <input type="text" name="res_building_name" id="res_building_name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_building_num">House/Bldg No:</label>
                                                <input type="text" name="res_building_num" id="res_building_num" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_street">Street:</label>
                                                <input type="text" name="res_street" id="res_street" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_subdivision">Subdivision/Village:</label>
                                                <input type="text" name="res_subdivision" id="res_subdivision" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_district">District:</label>
                                                <input type="text" name="res_district" id="res_district" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_region">Region:</label>
                                                <select name="res_region" id="res_region" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Region</option>
                                                    <?php foreach($region->list() as $region_data) :?>
                                                    <option value="<?=$region_data->regCode;?>"><?=$region_data->regDesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_province">Province:</label>
                                                <select name="res_province" id="res_province" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Provinces</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_municipality">Municipality:</label>
                                                <select name="res_municipality" id="res_municipality" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Municipalities</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="row">
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_brgy">Barangay:</label>
                                                <select name="res_brgy" id="res_brgy" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Barangays</option>>
                                                </select>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_zip_code">Zipcode:</label>
                                                <input type="text" name="res_zip_code" id="res_zip_code" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                
                                </div>

                            </div>
                            <!-- End of Residental Address -->

                            <!-- Start of Permanent Address -->
                            <div class="col-md-6">

                                <div class="alert pds-tab permanent-address-tab-bg-color" role="alert">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i> Permanent Address
                                </div>

                                <div class="permanent-address-form">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="res_room_num">Unit/Room No. Floor:</label>
                                                <input type="text" name="per_room_num" id="per_room_num" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_building_name">Building Name:</label>
                                                <input type="text" name="per_building_name" id="per_building_name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_building_num">House/Bldg No:</label>
                                                <input type="text" name="per_building_num" id="per_building_num" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_street">Street:</label>
                                                <input type="text" name="per_street" id="per_street" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_subdivision">Subdivision/Village:</label>
                                                <input type="text" name="per_subdivision" id="per_subdivision" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_district">District:</label>
                                                <input type="text" name="per_district" id="per_district" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_region">Region:</label>
                                                <select name="per_region" id="per_region" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Regions</option>
                                                    <?php foreach($region->list() as $region_data) :?>
                                                    <option value="<?=$region_data->regCode;?>"><?=$region_data->regDesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_province">Province:</label>
                                                <select name="per_province" id="per_province" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value=''>Provinces</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_municipality">Municipality:</label>
                                                <select name="per_municipality" id="per_municipality" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value=''>Municipalities</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="row">
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_brgy">Barangay:</label>
                                                <select name="per_brgy" id="per_brgy" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value=''>Barangays</option>
                                                </select>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_zip_code">Zipcode:</label>
                                                <input type="text" name="per_zip_code" id="per_zip_code" class="form-control">
                                            </div>
                                        </div>

                                    </div>
    
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="my-checkbox" id="use_same_address" name="use_same_address">
                                        <span class="same-address">Use the same address</span>
                                    </label>
                                </div>
                            
                            </div>
                            <!-- End of Permanent Address -->

                        </div>

                    </div>
                    <!-- End of Address Tab -->


                    <!-- Family Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="family">
                        
                        <div class="row">
                            
                            <div class="col-md-6">

                                <!-- Start of Mother Information -->
                                <div class="mother-info-form">

                                    <div class="alert pds-tab mother-tab-bg-color" role="alert">
                                        <i class="fa fa-female" aria-hidden="true"></i> Mother Information
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mmaidenname">Maiden Name:</label>
                                                <input type="text" class="form-control" id="mmaidenname" name="mmaidenname">
                                            </div>
                                        </div>                           

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="mlname">Last Name:</label>
                                                    <input type="text" class="form-control" id="mlname" name="mlname">
                                                </div>
                                            </div>
                                        </div> 

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mfname">First Name:</label>
                                                <input type="text" class="form-control" id="mfname" name="mfname">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mmname">Middle Name:</label>
                                                <input type="text" class="form-control" id="mmname" name="mmname">  
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="msuffix">Suffix:</label>
                                                <select name="msuffix" id="msuffix" class="form-control">
                                                    <option value="">Suffixes</option>
                                                    <?php foreach ($suffix->list() as $suffix_data) :?>
                                                    <option value="<?=$suffix_data->suffixdesc;?>"><?=$suffix_data->suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mbday">Birthday:</label>
                                                <input type="text" class="form-control" id="mbday" name="mbday">
                                            </div>
                                        </div>

                                    </div>  

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mcontact">Contact Number:</label>
                                                <input type="number" class="form-control" id="mcontact" name="mcontact">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="moccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="moccupation" name="moccupation">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mreligion">Religion:</label>
                                                <select class="form-control" id="mreligion" name="mreligion">
                                                    <option value="">Select a Religion</option>
                                                    <?php foreach ($religion->list() as $religion_data) :?>
                                                    <option value="<?=$religion_data->religiondesc;?>"><?=$religion_data->religiondesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mnationality">Nationality:</label>
                                                <select id="mnationality" name="mnationality" class="form-control" style="width: 100%;">
                                                    <option value="">List of Nationalities</option>
                                                    <?php foreach ($country->list() as $country_data) :?>
                                                    <option value="<?=$country_data->country_enNationality;?>"><?=$country_data->country_enNationality;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div> 
                                            
                                </div> 
                                <!-- End of Mother Information -->


                                <!-- Start of Spouse Information -->
                                <div class="spouse-info-form" style="margin-top: 20px;">

                                    <div class="alert pds-tab spouse-tab-bg-color" role="alert">
                                        <i class="fa fa-male" aria-hidden="true"></i> Spouse Information <i class="fa fa-female" aria-hidden="true"></i>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="slname">Last Name:</label>
                                                <input type="text" class="form-control" id="slname" name="slname">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sfname">First Name:</label>
                                                <input type="text" class="form-control" id="sfname" name="sfname">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="smname">Middle Name:</label>
                                                <input type="text" class="form-control" id="smname" name="smname">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ssuffix">Suffix:</label>
                                                <select name="ssuffix" id="ssuffix" class="form-control">
                                                    <option value="">Suffixes</option>
                                                    <?php foreach ($suffix->list() as $suffix_data) :?>
                                                    <option value="<?=$suffix_data->suffixdesc;?>"><?=$suffix_data->suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sbday">Birthday:</label>
                                                <input type="text" class="form-control" id="sbday" name="sbday">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sreligion">Religion:</label>
                                                <select class="form-control" id="sreligion" name="sreligion">
                                                    <option value="">Select a Religion</option>
                                                    <?php foreach ($religion->list() as $religion_data) :?>
                                                    <option value="<?=$religion_data->religiondesc;?>"><?=$religion_data->religiondesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="soccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="soccupation" name="soccupation">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ssalary">Salary:</label>
                                                <input type="number" class="form-control" id="ssalary" name="ssalary">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="snationality">Nationality:</label>
                                                <select id="snationality" name="snationality" class="form-control" style="width: 100%;">
                                                    <option value="">List of Nationalities</option>
                                                    <?php foreach ($country->list() as $country_data) :?>
                                                    <option value="<?=$country_data->country_enNationality;?>"><?=$country_data->country_enNationality;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!-- End of Spouse Information -->

                            </div>
            

                            <!-- Start of Father Information -->
                            <div class="col-md-6">
                                
                                <div class="father-info-form">

                                    <div class="alert pds-tab father-tab-bg-color" role="alert">
                                        <i class="fa fa-male" aria-hidden="true"></i> Father Information
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="flname">Last Name:</label>
                                                <input type="text" class="form-control" id="flname" name="flname">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ffname">First Name:</label>
                                                <input type="text" class="form-control" id="ffname" name="ffname">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fmname">Middle Name:</label>
                                                <input type="text" class="form-control" id="fmname" name="fmname">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fsuffix">Suffix:</label>
                                                <select id="fsuffix" name="fsuffix" class="form-control">
                                                    <option value="">Suffixes</option>
                                                    <?php foreach ($suffix->list() as $suffix_data) :?>
                                                    <option value="<?=$suffix_data->suffixdesc;?>"><?=$suffix_data->suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fbday">Birthday:</label>
                                                <input type="text" class="form-control" id="fbday" name="fbday">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fcontact">Contact Number: </label>
                                                <input type="number" class="form-control" id="fcontact" name="fcontact">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="foccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="foccupation" name="foccupation">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="freligion">Religion: </label>
                                                <select class="form-control" id="freligion" name="freligion">
                                                    <option value="">Select a Religion</option>
                                                    <?php foreach ($religion->list() as $religion_data) :?>
                                                    <option value="<?=$religion_data->religiondesc;?>"><?=$religion_data->religiondesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="fnationality">Nationality:</label>
                                                <select id="fnationality" name="fnationality" class="form-control" style="width: 100%;">
                                                    <option value="">List of Nationalities</option>
                                                    <?php foreach ($country->list() as $country_data) :?>
                                                    <option value="<?=$country_data->country_enNationality;?>"><?=$country_data->country_enNationality;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    
                                    </div>

                                </div>

                            </div>
                            <!-- Start of Father Information -->

                        </div>

                    </div>
                    <!-- End of Family Tab -->


                    <!-- Children Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="children">

                        <div class="row">
                            
                            <!-- Start of children info form -->
                            <div class="col-md-6">

                                <input type="hidden" id="child_table_data" name="child_table_data" value="[]">
                                
                                <form></form> 

                                <div class="alert pds-tab children-tab-bg-color">
                                    <i class="fa fa-child" aria-hidden="true"></i> Children Information
                                </div>

                                <form id="children-form">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="clname">Last Name:</label>
                                                <input type="text" class="form-control child-input" id="clname" name="clname">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cfname">First Name:</label>
                                                <input type="text" class="form-control child-input" id="cfname" name="cfname">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cmname">Middle Name:</label>
                                                <input type="text" class="form-control child-input" id="cmname" name="cmname">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="csuffix">Suffix:</label>
                                                <select class="form-control child-input" id="csuffix" name="csuffix">
                                                    <option value="">Suffixes</option>
                                                    <?php foreach ($suffix->list() as $suffix_data) :?>
                                                    <option value="<?=$suffix_data->suffixdesc;?>"><?=$suffix_data->suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cdob">Date of Birth:</label>
                                                <input type="text" class="form-control child-input" id="cdob" name="cdob">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cpob">Place of Birth: </label>
                                                <input type="text" class="form-control child-input" id="cpob" name="cpob">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cgender">Gender: </label>
                                                <select id="cgender" name="cgender" class="form-control child-input">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ccivilstatus">Civil Status:</label>
                                                <select id="ccivilstatus" name="ccivilstatus" class="form-control child-input">
                                                    <option value="">Select Civil Status</option>
                                                    <?php foreach ($civil_status->list() as $civil_status_data) :?>
                                                        <option value="<?=$civil_status_data->civilstatusdesc;?>">
                                                            <?=$civil_status_data->civilstatusdesc;?>        
                                                        </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="coccupation">Occupation: </label>
                                                <input type="text" class="form-control child-input" id="coccupation" name="coccupation">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="csalary">Salary: </label>
                                                <input type="number" class="form-control child-input" id="csalary" name="csalary" min="0">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cphysical">Physical Status: </label>
                                                <select id="cphysical" name="cphysical" class="form-control child-input">
                                                    <option value="">Physical Status</option>
                                                    <?php foreach ($physical_status->list() as $ps_data) :?>
                                                    <option value="<?=$ps_data->id;?>"><?=$ps_data->physical_status_name;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ceduclevel">Educational Level: </label>
                                                <select id="ceduclevel" name="ceduclevel" class="form-control child-input">
                                                    <option value="">Level</option>
                                                    <option value="Elementary">Elementary</option>
                                                    <option value="Secondary">Secondary</option>
                                                    <option value="Vocational Trade Course">Vocational Trade Course</option>
                                                    <option value="College">College</option>
                                                    <option value="Graduate Studies">Graduate Studies</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="cschool">School: </label>
                                                <input type="text" class="form-control child-input" id="cschool" name="cschool">
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <input type="hidden" id="child_id" class="child-input">

                                    <div class="row">

                                        <div class="col-md-12 ">
                                            <div class="form-group pull-right">
                                                <button type="submit" id="child_button" class="btn my-btn mr-3" onclick="addChild()">
                                                    <i class="fa fa-plus my-green"></i> New
                                                </button>
                                                <button type="button" id="cancel_child_btn" class="btn my-btn" onclick="clearChildForm()">
                                                    <i class="fa fa-times radical-red"></i> Cancel
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </form>
                                
                            </div>
                            <!-- End of children info form -->

                            <!-- Start of Children Table -->
                            <div class="col-md-6">

                                 <div class="panel panel-default">
                                    
                                    <div class="panel-heading fs-13">
                                        <i class="fas fa-list my-green" aria-hidden="true"></i> Children List
                                    </div>

                                    <div class="panel-body">
                                        <div id="children_tbl_container" class="table-responsive">
                                            <table class="table table-striped" id="children_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Birthdate</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!-- End of Children Table -->

                        </div>       
                                        
                    </div>
                    <!-- Children Tab -->
                    

                    <!-- Education Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="education">
                       
                        <div class="row">

                            <div class="col-md-6">

                                <div class="alert pds-tab education-tab-bg-color">
                                    <i class="fas fa-graduation-cap"></i> Educational Information
                                </div>

                                <input type="hidden" id="educ_table_data" name="educ_table_data" value="[]">

                                <form id="education-form">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="educlevel">Educational Level:</label>
                                                <select name="educlevel" id="educlevel" class="form-control educ-input">
                                                    <option value="">Select Educational Level</option>
                                                    <option value="Elementary">Elementary</option>
                                                    <option value="Secondary">Secondary</option>
                                                    <option value="Vocational Trade Course">Vocational Trade Course</option>
                                                    <option value="College">College</option>
                                                    <option value="Graduate Studies">Graduate Studies</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="schooltype">School Type: </label>
                                                <select name="schooltype" id="schooltype" class="form-control educ-input">
                                                    <option value="">Select School Type</option>
                                                    <option value="Semi Public">Semi Public</option>
                                                    <option value="Public">Public</option>
                                                    <option value="Semi Private">Semi Private</option>
                                                    <option value="Private">Private</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="schoolname">Name of School:</label>
                                                <input type="text" class="form-control educ-input" id="schoolname" name="schoolname">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="degreecourse">Degree Course: </label>
                                                <input type="text" class="form-control educ-input" id="degreecourse" name="degreecourse">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="yeargraduated">Year Graduated: </label>
                                                <select name="yeargraduated" id="yeargraduated" class="form-control educ-input">
                                                    <option value="">Select Year Graduated</option>
                                                    <?php for($i=1900; $i <= date("Y"); $i++) :?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="highestgrade">Highest Grade: </label>
                                                <input type="number" class="form-control educ-input" id="highestgrade" name="highestgrade" min="0">
                                            </div>  
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="graduatedfrom">Graduated From: </label>
                                                <input type="text" class="form-control educ-input" id="graduatedfrom" name="graduatedfrom">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="graduatedto">Graduated To: </label>
                                                <input type="text" class="form-control educ-input" id="graduatedto" name="graduatedto">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="scholarship">Scholarship/Honors Received: </label>
                                                <input type="text" class="form-control educ-input" id="scholarship" name="scholarship">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <input type="hidden" id="educ_id" class="educ-input">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button type="submit" id="educ_button" class="btn my-btn mr-3" onclick="addEducation()">
                                                    <i class="fa fa-plus my-green mr-3"></i> New
                                                </button>
                                                <button type="button" id="cancel_educ_button" class="btn my-btn" onclick="clearEducationForm()">
                                                    <i class="fa fa-times radical-red"></i> Cancel
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </form>

                            </div>

                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    
                                    <div class="panel-heading fs-13">
                                        <i class="fa fa-list my-green" aria-hidden="true"></i> List of Educational Attainment
                                    </div>
                                    
                                    <div class="panel-body">
                                        <div id ="education_tbl_container" class="table-responsive">
                                            <table class="table table-striped" id="education_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Level</th>
                                                        <th class="text-center">School</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    
                    </div>
                    <!-- End of Education Tab -->
                    

                    <!-- Start of Trainings Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="trainings">
                        
                        <div class="row">

                            <div class="col-md-6">

                                <div class="alert pds-tab awards-tab-bg-color">
                                    <i class="fas fa-certificate"></i> Trainings
                                </div>

                                <input type="hidden" id="training_table_data" name="training_table_data" value="[]">

                                <form id="training-form">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="seminar">Seminar/Workshop:</label>
                                                <input type="text" class="form-control training-input" id="seminar" name="seminar">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="seminardatefrom">Date From: </label>
                                                <input type="text" class="form-control training-input" id="seminardatefrom" name="seminardatefrom">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="seminardateto">Date To: </label>
                                                <input type="text" class="form-control training-input" id="seminardateto" name="seminardateto">
                                            </div> 
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="seminarhours">Hours:</label>
                                                <input type="text" class="form-control training-input" id="seminarhours" name="seminarhours">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sponsoredby">Sponsored By: </label>
                                                <input type="text" class="form-control training-input" id="sponsoredby" name="sponsoredby">
                                            </div>
                                        </div>

                                    </div>

                                    <input type="hidden" id="training_id" class="training-input">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button type="submit" id="training_button" onclick="addTraining()" class="btn my-btn mr-3">
                                                    <i class="fa fa-plus my-green"></i> New
                                                </button>
                                                <button type="button" id="cancel_training_button" onclick="clearTrainingForm()" class="btn my-btn">
                                                    <i class="fa fa-times radical-red"></i> Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>

                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading fs-13">
                                        <i class="fas fa-list my-green" aria-hidden="true"></i> List of Trainings Attainment
                                    </div>
                                    
                                    <div class="panel-body table-responsive">
                                        <div id="training_tbl_container" class="table-responsive">
                                            <table class="table table-striped" id="training_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Seminar/Workshop</th>
                                                        <th class="text-center">From</th>
                                                        <th class="text-center">To</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>  
                                            </table>
                                        </div>
                                    </div>
                                </div>
                    
                            </div>

                        </div>

                    </div>
                    <!-- End of Trainings Tab -->


                    <!-- Start of Eligibilty Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="eligibility">
                        
                        <div class="row">

                            <div class="col-md-6">

                                <div class="alert pds-tab eligibility-tab-bg-color" role="alert">
                                    <i class="fa fa-check" aria-hidden="true"></i> Eligibility
                                </div>

                                <input type="hidden" id="eligibility_table_data" name="eligibility_table_data" value="[]">

                                <form id="eligibility-form">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="career_services">Career Services:</label>
                                                <select class="form-control eligib-input" name="career_services" id="career_services" >
                                                    <option value="">Select Career Service</option>
                                                    <?php foreach ($career_service->list() as $career_service_data) :?>
                                                    <option value="<?=$career_service_data->careerservicedesc;?>">
                                                        <?=$career_service_data->careerservicedesc;?>
                                                    </option>
                                                    <?php endforeach ;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rating">Ratings:</label>
                                                <input type="text" class="form-control eligib-input" name="rating" id="rating">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="examdate">Exam Date:</label>
                                                <input type="text" class="form-control eligib-input" name="examdate" id="examdate">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="place">Place:</label>
                                                <input type="text" class="form-control eligib-input" name="place" id="place">
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="licensenum">License Number:</label>
                                                <input type="text" class="form-control eligib-input" name="licensenum" id="licensenum">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="licensedate">License Date:</label>
                                                <input type="text" class="form-control eligib-input" name="licensedate" id="licensedate">
                                            </div>
                                        </div>

                                    </div>

                                    <input type="hidden" class="form-control" id="eligibility_id">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button type="button" id="eligibility_button" class="btn my-btn mr-3" onclick="addEligibility()">
                                                    <i class="fa fa-plus my-green"></i> New
                                                </button>
                                                <button type="button" id="cancel_eligibility_button" class="btn my-btn" onclick="clearEligibilityForm()">
                                                    <i class="fa fa-times radical-red"></i> Cancel
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </form>

                            </div>
                            
                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading fs-13">
                                        <i class="fa fa-list my-green" aria-hidden="true"></i> List of Career Attainment
                                    </div>
                                    
                                    <div class="panel-body table-responsive">
                                        <div id="eligibility_tbl_container" class="table-responsive">
                                            <table class="table table-striped" id="eligibility_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Career</th>
                                                        <th class="text-center">Licence No.</th>
                                                        <th class="text-center">Released</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                    
                            </div>

                        </div>
                    
                    </div>
                    <!-- End of Eligibilty Tab -->


                    <!-- Start of Medical Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="medical">
                        
                        <div class="row">
                            
                            <!-- Start of Surgery -->
                            <div class="col-md-6">
                                
                                <div class="alert pds-tab surgery-tab-bg-color" role="alert">
                                    <i class="fa fa-heartbeat" aria-hidden="true"></i> Surgery
                                </div>

                                <div class="form-horizontal">

                                    <div class="col-md-12 pad-3">
                                        <label for="career_services" class="col-sm-7 control-label">Did you undergo in any physical improvement surgery?</label>
                                        <div class="col-sm-5">
                                            <div class="checkbox clr-gry" >
                                                <label><input type="radio" class="pds-radio" name="choice1" value="Male">&nbsp; Yes</label>
                                                <label><input type="radio" class="pds-radio" name="choice1" value="Male">&nbsp; No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-top:10px !important;">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Other Surgery: </label>
                                            <div class="col-sm-7">
                                                <input type="text" name="specific_surg_type" id="specific_surg_type" class="form-control" placeholder="Please specify here">
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>

                                
                            </div>
                            <!-- End of Surgery -->

                            <div class="col-md-6">

                                <div class="alert pds-tab medical-history-tab-bg-color" role="alert">
                                    <i class="fa fa-hospital" aria-hidden="true"></i> <strong>Medical History</strong>
                                </div>

                            </div>
                            
                        </div>
                        
                    </div>
                    <!-- End of Medical Tab -->


                    <!-- Start of Organization Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="organization">
                        
                        <div class="row">
                            
                            <div class="col-md-6">

                                <div class="alert pds-tab organization-reference-tab-bg-color">
                                    <i class="far fa-address-card"></i> Organization Information
                                </div>

                                <div class="org-reference-form">

                                    <div class="row">
                                        
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="org_origin">Organization Origin:</label>
                                                <select name="org_origin" id="org_origin" class="form-control">
                                                    <option value="">Select an Origin</option>
                                                    <?php foreach($source->list() as $source_data) :?>
                                                    <option value="<?=$source_data->id;?>"><?=$source_data->sourcedesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label for="org_type">Organization Type:</label>
                                                <select name="org_type" id="org_type" class="form-control">
                                                    <option value="">Select an Organization Type</option>
                                                    <?php foreach ($org_type->list() as $org_type_data):?>
                                                    <option value="<?=$org_type_data->id;?>"><?=$org_type_data->orgtypedesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_name">Organization Name:</label>
                                                <input type="text" class="form-control" name="org_name" id="org_name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_status">Organization Status:</label>
                                                <input type="text" class="form-control" name="org_status" id="org_status">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="org_position">Position: </label>
                                                <select name="org_position" id="org_position" class="form-control" style="width: 100%;">
                                                    <option value="">Positions List</option>
                                                    <?php foreach ($position->list() as $position_data) :?>
                                                    <option value="<?=$position_data->posncode;?>"><?=$position_data->posndesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="org_purpose">Organization Purpose:</label>
                                                <textarea name="org_purpose" id="org_purpose" rows="9" class="form-control"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>
                                
                            </div>

                            <div class="col-md-6">

                                <div class="alert pds-tab organization-address-tab-bg-color" role="alert">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i> Organization Address
                                </div>

                                <div class="org-address-form">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="org_room_num">Unit/Room No. Floor:</label>
                                                <input type="text" name="org_room_num" id="org_room_num" class="form-control">
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_building_name">Building Name:</label>
                                                <input type="text" name="org_building_name" id="org_building_name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_building_num">House/Bldg No:</label>
                                                <input type="text" name="org_building_num" id="org_building_num" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_street">Street:</label>
                                                <input type="text" name="org_street" id="org_street" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_subdivision" >Subdivision/Village:</label>
                                                <input type="text" name="org_subdivision" id="org_subdivision" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_district">District:</label>
                                                <input type="text" name="org_district" id="org_district" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_region">Region:</label>
                                                <select name="org_region" id="org_region" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Regions</option>
                                                    <?php foreach($region->list() as $region_data) :?>
                                                    <option value="<?=$region_data->regCode;?>"><?=$region_data->regDesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="org_province">Province:</label>
                                                <select name="org_province" id="org_province" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value=''>Provinces</option>
                                                </select>
                                            </div>
                                        
                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="org_municipality">Municipality:</label>
                                                <select name="org_municipality" id="org_municipality" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value=''>Municipalities</option>
                                                </select>
                                            </div>

                                        </div>

                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_brgy">Barangay:</label>
                                                <select name="org_brgy" id="org_brgy" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value=''>Barangays</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_zip_code">Zipcode:</label>
                                                <input type="text" name="org_zip_code" id="org_zip_code" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                
                                </div>
                                
                            </div>

                        </div>
                    
                    </div> 
                    <!-- End of Organization Tab -->    
                
                </div>

            </div>
        </div>
        
    </form>

    </div>

</div>

<?php 
    include '../includes/footer.php';
    include '../includes/scripts.php';
?>

<script type="text/javascript">
    
var url = "/miaa/module/gender/";
var pdsSourceURL = url+"lib/pds_type_source.php";
var pdsExistsURL = url+"lib/check_if_pds_exists.php";
var childServerURL= url+"lib/process_pds_children.php";
var educationServerURL= url+"lib/process_pds_education.php";
var trainingServerURL= url+"lib/process_pds_training.php";
var eligibilityServerURL= url+"lib/process_pds_eligibility.php";

</script>
<script src="<?=JS;?>jquery.validate.js"></script>
<script src="<?=JS;?>validate-help-block.js"></script>
<script src="<?=JS;?>intl-tel-input-master/build/js/intlTelInput.min.js"></script>
<script src="<?=ASSETS;?>templates/AdminLTE-master/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?=JS;?>pds/pds-validation-var.js"></script>
<script src="<?=JS;?>pds/pds-validation.js"></script>
<script src="<?=JS;?>pds/pds-employee.js"></script>
<script src="<?=JS;?>pds/pds-concessionaire.js"></script>
<script src="<?=JS;?>pds/pds-passenger.js"></script>
<script src="<?=JS;?>pds/pds-visitor.js"></script>
<script src="<?=JS;?>filter-org.js"></script>
<script src="<?=JS;?>filter-address.js"></script>
<script src="<?=JS;?>pds/pds-webcam.js"></script>
<script src="<?=JS;?>pds/pds-children.js"></script>
<script src="<?=JS;?>pds/pds-education.js"></script>
<script src="<?=JS;?>pds/pds-training.js"></script>
<script src="<?=JS;?>pds/pds-eligibility.js"></script>
<script src="<?=JS;?>pds/main-pds.js"></script>

<script type="text/javascript">

/* Start of MIAA organizations filter functions */
$("#office").change(() => { 
    getDepartments(url+"lib/filter_dept.php");
});

$("#department").change(() => { 
    getDivisions(url+"lib/filter_div.php");
});
/* End of MIAA organizations filter functions */


/* Start of residential address filter functions */
$("#res_region").change(() => {
    getProvinces(url+"lib/filter_prov.php", "#res_region", "#res_province"); 
});

$("#res_province").change(() => {
    getMunicipalities(url+"lib/filter_mun.php", "#res_region", "#res_province", "#res_municipality");
});

$("#res_municipality").change(() => {
    getBarangays(url+"lib/filter_brgy.php", "#res_region", "#res_province", "#res_municipality","#res_brgy"); 
});
/* End of residential address filter functions */


/* Start of permanent address filter functions */
$("#per_region").change(() => {
    getProvinces(url+"lib/filter_prov.php", "#per_region", "#per_province"); 
});

$("#per_province").change(() => {
    getMunicipalities(url+"lib/filter_mun.php", "#per_region", "#per_province", "#per_municipality");
});

$("#per_municipality").change(() => {
    getBarangays(url+"lib/filter_brgy.php", "#per_region", "#per_province", "#per_municipality","#per_brgy"); 
});
/* End of permanent address filter functions */


/* Start of organization address filter functions */
$("#org_region").change(() => {
    getProvinces(url+"lib/filter_prov.php", "#org_region", "#org_province"); 
});

$("#org_province").change(() => {
    getMunicipalities(url+"lib/filter_mun.php", "#org_region", "#org_province", "#org_municipality");
});

$("#org_municipality").change(() => {
    getBarangays(url+"lib/filter_brgy.php", "#org_region", "#org_province", "#org_municipality","#org_brgy"); 
});
/* End of organization address filter functions */


/* PDS type select tag function 
   Get the source id of pds type
*/
$("#pds_type").on("change", function() {

    $.ajax({
        url: pdsSourceURL,
        type: "POST",
        dataType: "JSON",
        data: { pds_type: $(this).val() },
        success: function(res) 
        {
            $("#source").val(res);
            
            let selected = $("#pds_type option:selected").text();
            
            // change the name, id and placeholder of input based on pds type
            switch (selected) 
            {
                case 'Employee': 

                    changeTextID("Employee ID:")
                    
                    changeIdAndName("employee_id");
                    
                    $("#employee_id").find("option").remove();

                    searchEmployee(url+"lib/search_employee.php");
                    
                    checkIfPdsExists(pdsExistsURL,"#employee_id","empno");
                    
                break;
                    
                case 'Passenger': 
                
                    changeTextID("Passenger ID:")

                    changeIdAndName("passenger_id");

                    $("#passenger_id").find("option").remove();

                    searchPassenger(url+"lib/search_passenger.php");

                    checkIfPdsExists(pdsExistsURL,"#passenger_id","passcode");
                
                break;
            
                case 'Concessionaire': 

                    changeTextID("Concessionaire ID:")

                    changeIdAndName("concessionaire_id");

                    $("#concessionaire_id").find("option").remove();

                    searchConcessionaire(url+"lib/search_concessionaire.php");

                    checkIfPdsExists(pdsExistsURL,"#concessionaire_id","concode");
                    
                break;
                    
                case 'Visitor/Walk In': 

                    changeTextID("Visitor ID:")

                    changeIdAndName("visitor_id");

                    $("#visitor_id").find("option").remove();

                    searchVisitor(url+"lib/search_visitor.php");

                    checkIfPdsExists(pdsExistsURL,"#visitor_id","visitcode");

                break;
            }
        }
    });  
    
    if ($("#pds_type").val() === "") {
        changeTextID("Corresponding ID:","(Select PDS type first)");
    }

});

</script>
