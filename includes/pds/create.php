<?php 
require 'core/init.php';
include 'includes/styles.php';
include 'includes/navbar.php';

use Gender\Classes\PDS;
use Gender\Classes\Address;
use Gender\Classes\Organization;

$PDS = new PDS;
$PDS -> newForm(['appno' => $PDS -> futureID()]);

$address = new Address;
$org = new Organization;
?>


<div class="container-fluid mt-40">

    <div class="col-md-12">
    
    <form action="lib/process_pds.php" method="POST" id="pds_form" enctype="multipart/form-data">
        
        <div class="well well-md text-right">
            <div class="form-inline">
                <div class="form-group">
                    <span class="data-entry-msg">Do you want to add this record ?</span>
                </div>
                <button type="submit" id="save_pds_btn" name="save_pds_btn" class="btn my-btn"><i class="fa fa-check"></i> OK</button>
                <button type="button" class="btn my-btn" id="cancel_pds_btn"><i class="fa fa-times"></i> CANCEL</button>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><img src="/miaa/assets/images/add_user.svg" class="user-icon">&nbsp; PDS DATA ENTRY <span class="pull-right"></h3>
            </div>
            <div class="panel-body">
                
                <div class="form-horizontal" style="margin-bottom:-15px;">

                    <div class="container-fluid">
                    
                        <div class="row">

                            <div class="col-md-2">

                                <div class="form-group">

                                    <div class="col-sm-12 pad-3 text-center">
                                        <input type="text" class="form-control" id="appNumber" name="appNumber" value="<?php echo $PDS -> latestID();?>" readonly>
                                        <label for="appNumber" style="margin-top:5px;">Application No:</label>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-9 pull-right">

                                <div class="form-group">

                                    <div class="col-sm-2 pad-3 text-center">
                                        <input type="text" class="form-control" id="csc_id" name="csc_id">
                                        <label for="csc_id" style="margin-top:5px;">CSC ID NO.</label>
                                    </div>
                                    
                                    <div class="col-sm-2 pad-3 text-center">
                                    <select name="prefix" id="prefix" class="form-control">
                                            <option value="">Prefix</option>
                                            <?php foreach ($PDS -> getPrefixes() as $prefix) :?>
                                            <option value="<?php echo $prefix -> prefixdesc;?>"><?php echo $prefix -> prefixdesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <label for="prefix" style="margin-top:5px;">Prefix</label>
                                    </div>
                                
                                    <div class="col-sm-2 pad-3 text-center">
                                        <input type="text" class="form-control" id="lname" name="lname" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                        <label for="lname" style="margin-top:5px;">Lastname</label>
                                    </div>

                                    <div class="col-sm-2 pad-3 text-center">
                                        <input type="text" class="form-control" id="fname" name="fname" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                        <label for="fname" style="margin-top:5px;">Firstname</label>
                                    </div>

                                    <div class="col-sm-2 pad-3 text-center">
                                        <input type="text" class="form-control" id="mname" name="mname">
                                        <label for="mname" style="margin-top:5px;">Middlename</label>
                                    </div>

                                    <div class="col-sm-2 pad-3 text-center">
                                    <select name="suffix" id="suffix" class="form-control">
                                            <option value="">Suffix</option>
                                            <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                            <option value="<?php echo $suffix -> suffixdesc;?>"><?php echo $suffix -> suffixdesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <label style="margin-top:5px;">Suffix</label>
                                    </div>

                                </div>
                        
                            </div>

                            

                        </div>

                    </div>

                </div><br>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#information" aria-controls="information" role="tab" data-toggle="tab"><strong>INFORMATION</strong></a></li>
                    <li role="presentation"><a href="#address" aria-controls="address" role="tab" data-toggle="tab"><strong>ADDRESS</strong></a></li>
                    <li role="presentation"><a href="#family" aria-controls="family" role="tab" data-toggle="tab"><strong>FAMILY</strong></a></li>
                    <li role="presentation"><a href="#children" aria-controls="children" role="tab" data-toggle="tab"><strong>CHILDREN</strong></a></li>
                    <li role="presentation"><a href="#education" aria-controls="education" role="tab" data-toggle="tab"><strong>EDUCATION</strong></a></li>
                    <li role="presentation"><a href="#trainings" aria-controls="trainings" role="tab" data-toggle="tab"><strong>TRAINING</strong></a></li>
                    <li role="presentation"><a href="#eligibility" aria-controls="eligibility" role="tab" data-toggle="tab"><strong>ELIGIBILITY</strong></a></li>
                    <li role="presentation"><a href="#medical" aria-controls="medical" role="tab" data-toggle="tab"><strong>MEDICAL</strong></a></li>
                    <li role="presentation"><a href="#organization" aria-controls="organization" role="tab" data-toggle="tab"><strong>ORGANIZATION</strong></a></li>
                </ul><br>

                <div class="tab-content">

                    <!-- Information Tab -->
                    <div role="tabpanel" class="tab-pane fade in active" id="information">
                        <div class="row">
                        
                            <div class="col-md-6">

                                <div class="alert pds-tab personal-tab-bg-color" role="alert">
                                    <i class="fa fa-user" aria-hidden="true"></i> <strong>Personal Information</strong>
                                </div>
                            
                                <div class="form-group text-center">
                                    <img class="img-circle" src="/miaa/assets/images/evaluation_pics/miriam.png" width="150" height="150" id="person_img" name="person_img">
                                </div>

                                <div class="form-group text-center">
                                    <label class="btn my-btn"><i class="far fa-file-image" aria-hidden="true"></i> Browse <input type="file" style="display: none;" name="person_img_file" id="person_img_file" onchange="readURL(this,'person_img');" accept="image/x-png, image/gif, image/jpeg"></label>
                                    <button type="button" id="webcam-button" class="btn my-btn"><i class="fa fa-camera-retro" aria-hidden="true"></i> Use Webcam</button>
                                </div>    
                            
                                <div class="information-form">
                                
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            
                                            <div class="form-group">
                                                <label for="height">Height (m):</label>
                                                <input type="text" class="form-control" id="height" name="height" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="gender">Gender:</label>
                                                <select name="gender" id="gender" class="form-control" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                    <option value="">Gender</option>
                                                    <option value="1">Male</option>
                                                    <option value="0">Female</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            
                                            <div class="form-group">
                                                <label for="weight">Weight (kg):</label>
                                                <input type="text" class="form-control" id="weight" name="weight" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="bday">Birthday:</label>
                                                <input type="text" class="form-control" id="bday" name="bday" required>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            
                                            <div class="form-group">
                                                <label for="blood_type">Blood Type:</label>
                                                <select name="blood_type" id="blood_type" class="form-control" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                    <option value="">Blood Type</option>
                                                    <option value="O-positive">O-positive</option>
                                                    <option value="O-negative">O-negative</option>
                                                    <option value="A-positive">A-positive</option>
                                                    <option value="A-negative">A-negative</option>
                                                    <option value="B-positive">B-positive</option>
                                                    <option value="B-negative">B-negative</option>
                                                    <option value="AB-positive">AB-positive</option>
                                                    <option value="AB-negative">AB-negative</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="age">Age:</label>
                                                <input type="text" class="form-control" id="age" name="age" readonly>
                                            </div>

                                        </div>
                                        
                                        <!-- Left Side -->
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label for="organization">Gender Preference:</label>
                                                <select name="gender_pref" id="gender_pref" class="form-control" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                    <option value="">Gender Preferences</option>
                                                    <?php foreach ($PDS -> getGenderPreferences() as $genderpref) :?>
                                                        <option value="<?php echo $genderpref -> id;?>"><?php echo $genderpref -> genderdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="citizenship">Source</label>
                                                <select name="" id="" class="form-control">
                                                    <option value="internal">Internal</option>
                                                    <option value="external">External</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="employment_type">Employment Type:</label>
                                                <select name="employment_type" id="employment_type" class="form-control" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                    <option value="">Employment Type</option>
                                                    <?php foreach ($PDS -> getEmploymentTypes() as $employmentType) :?>
                                                        <option value="<?php echo $employmentType -> typecode;?>"><?php echo $employmentType -> typedesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="civil_status">Civil Status:</label>
                                                <select name="civil_status" id="civil_status" class="form-control" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                    <option value="">Select Civil Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Widow">Widow</option>
                                                    <option value="Seperated">Seperated</option>
                                                    <option value="Annulled">Annulled</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Phone Number: </label>
                                                <input type="text" class="form-control" id="phone" name="phone" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">  
                                            </div>

                                            <div class="form-group">
                                                <label for="nationality">Nationality: </label>
                                                <input type="text" class="form-control" id="nationality" name="nationality" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>

                                            

                                        </div>

                                        <!-- Right Side -->
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label for="pob">Place of Birth:</label>
                                                <input type="text" class="form-control" id="pob" name="pob">
                                            </div>

                                            <div class="form-group">
                                                <label for="employee_id">Employee ID <small class="clr-gry">(Don't fill up if not an Employee)</small></label>
                                                <input type="text" class="form-control" id="employee_id" name="employee_id">
                                            </div>

                                            <div class="form-group">
                                                <label for="position">Position: </label>
                                                <select name="position" id="position" class="form-control" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                    <option value="">Position</option>
                                                    <?php foreach ($PDS -> getPositions() as $position) :?>
                                                    <option value="<?php echo $position -> posncode;?>"><?php echo $position -> posndesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email Address: </label>
                                                <input type="email" class="form-control" id="email" name="email" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="telephone">Telephone Number: </label>
                                                <input type="text" class="form-control" id="telephone" name="telephone" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="religion">Religion:</label>
                                                <input type="text" class="form-control" id="religion" name="religion">
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
                                                <div class="col-md-6" style="padding:10px;">
                                                    <video id="video" autoplay="autoplay" class="img-responsive"></video>
                                                </div>
                                                <div class="col-md-6" style="padding:10px;">
                                                    <img src="../../assets/images/image-preview.png" id="preview_img" class="img-responsive" alt="preview">
                                                </div>
                                                <input type="hidden" name="webcam_img" id="webcam_img" class="form-control" value="">
                                                <canvas id="canvas" style="display:none;"></canvas>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn my-btn" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                                            <button type="button" id="buttonSnap" class="btn my-btn" onclick="snapshot()"><i class="fa fa-camera" aria-hidden="true"></i> Take Snapshot</button>
                                            <button type="button"class="btn my-btn" onclick="saveImage()"><i class="fas fa-save"></i> Save</button>
                                        </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- End of Webcam Modal -->

                            </div>

                            <div class="col-md-6">

                                <!-- Start of Offices Tab -->
                                <div class="alert pds-tab offices-tab-bg-color" role="alert">
                                    <i class="fas fa-briefcase"></i> <strong>Offices/Departments/Divisions</strong>
                                </div>

                                <div class="form-horizontal">
            
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="office" class="col-sm-2 control-label">Offices: </label>
                                                <div class="col-sm-10">
                                                <select name="office" id="office" class="form-control" onchange="getDepartments('office','department')">
                                                    <option value="">Lists of Offices</option>
                                                    <?php foreach($org -> offices() as $office):?>
                                                    <option value="<?php echo $office -> offcode;?>"><?php echo $office -> offdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="department" class="col-sm-2 control-label">Departments: </label>
                                                <div class="col-sm-10">
                                                <select name="department" id="department" class="form-control" onchange="getDivisions('department','division')">
                                                    <option value="">Lists of Departments</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="division" class="col-sm-2 control-label">Divisions: </label>
                                                <div class="col-sm-10">
                                                <select name="division" id="division" class="form-control">
                                                    <option value="">Lists of Divisions</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>
                                <!-- End of Offices Tab -->

                                <!-- Start of Government Credentials -->
                                <br>
                                <div class="gov-credentials-form">

                                    <div class="alert pds-tab goverment-person-tab-bg-color" role="alert">
                                        <i class="fas fa-building"></i> <strong>Government Credentials</strong>
                                    </div>
            
                                    <div class="row">
                                        
                                        

                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label for="gsis">GSIS ID NO: </label>
                                                <input type="text" class="form-control" id="gsis" name="gsis" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="philhealth">PHILHEALTH NO: </label>
                                                <input type="text" class="form-control" id="philhealth" name="philhealth" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="tin">TIN NO: </label>
                                                <input type="text" class="form-control" id="tin" name="tin" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="csc_id_num">CSC ID NO: </label>
                                                <input type="text" class="form-control" id="csc_id_num" name="csc_id_num" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label for="pagibig">PAGIBIG ID NO: </label>
                                                <input type="text" class="form-control" id="pagibig" name="pagibig" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group" style="padding-left:3px;">
                                                <label for="sss">SSS NO: </label>
                                                <input type="text" class="form-control" id="sss" name="sss"  oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="voter_id_num">VOTER ID NO: </label>
                                                <input type="text" class="form-control" id="voter_id_num" name="voter_id_num" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                            </div>

                                            <div class="form-group">
                                                <label for="csc_id_num">NBI ID NO: </label>
                                                <input type="text" class="form-control" id="csc_id_num" name="csc_id_num">
                                            </div>
                                        
                                        </div>

                                    </div>
                                    
                                </div>
                                <!-- End of Government Credentials -->

                                <br>
                                <div class="contact-person-info-form">

                                    <div class="alert pds-tab contact-person-tab-bg-color" role="alert">
                                        <i class="fa fa-phone" aria-hidden="true"></i> <strong>Contact Person Information</strong>
                                    </div>
                                    
                                    <div class="row">

                                        <!-- Left Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="cplname">Last Name:</label>
                                                <input type="text" class="form-control" id="cplname" name="cplname">
                                            </div>

                                            <div class="form-group">
                                                <label for="cpmname">Middle Name:</label>
                                                <input type="text" class="form-control" id="cpmname" name="cpmname">
                                            </div>

                                            <div class="form-group">
                                                <label for="cprelationship">Relationship: </label>
                                                <input type="text" class="form-control" id="cprelationship" name="cprelationship">
                                            </div>

                                        </div>
                                        
                                        <!-- Right Side -->
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label for="cpfname">First Name:</label>
                                                <input type="text" class="form-control" id="cpfname" name="cpfname">
                                            </div>

                                            <div class="form-group">
                                                <label for="cpsuffix">Suffix:</label>
                                                <select name="cpsuffix" id="cpsuffix" class="form-control">
                                                    <option value="">Suffix</option>
                                                    <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                                    <option value="<?php echo $suffix -> suffixdesc;?>"><?php echo $suffix -> suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="cpcontactnum">Contact Number: </label>
                                                <input type="text" class="form-control" id="cpcontactnum" name="cpcontactnum">
                                            </div>
                                        
                                        </div>

                                    </div>
                                    
                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- End of Information Tab -->


                    <!-- Address Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="address">
                        <div class="row">

                            <div class="col-md-6">

                                <div class="alert pds-tab residential-address-tab-bg-color" role="alert">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Residential Address</strong>
                                </div>

                                <div class="residential-address-form">
                                    
                                    <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="res_room_num">Unit/Room No. Floor:</label>
                                            <input type="text" name="res_room_num" id="res_room_num" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <!-- Left Side -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="res_building_name">Building Name:</label>
                                            <input type="text" name="res_building_name" id="res_building_name" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="res_subdivision">Subdivision/Village:</label>
                                            <input type="text" name="res_subdivision" id="res_subdivision" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="res_district">District:</label>
                                            <input type="text" name="res_district" id="res_district" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="res_province">Province:</label>
                                            <select name="res_province" id="res_province" class="form-control"  onchange="getMunicipalities('res_region','res_province','res_municipality')" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                <option value=''>Province</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="res_brgy">Barangay:</label>
                                            <select name="res_brgy" id="res_brgy" class="form-control" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                <option value=''>Barangay</option>>
                                            </select>
                                        </div>
                                    
                                    </div>
                                    
                                    <!-- Right Side -->
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            <label for="res_building_num">House/Bldg No:</label>
                                            <input type="text" name="res_building_num" id="res_building_num" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="res_street">Street:</label>
                                            <input type="text" name="res_street" id="res_street" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="res_region">Region:</label>
                                            <select name="res_region" id="res_region" class="form-control" onchange="getProvinces('res_region','res_province')" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                <option value="">Region</option>
                                                <?php foreach($address -> getRegions() as $region) :?>
                                                <option value="<?php echo $region -> regCode;?>"><?php echo $region -> regDesc;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="res_municipality">Municipality:</label>
                                            <select name="res_municipality" id="res_municipality" class="form-control" onchange="getBarangays('res_region','res_province','res_municipality','res_brgy')" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                <option value=''>Municipality</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="res_zip_code">Zipcode:</label>
                                            <input type="text" name="res_zip_code" id="res_zip_code" class="form-control">
                                        </div>
                                    
                                    </div>

                                    </div>
                                
                                </div>
                                
                            </div>

                            <div class="col-md-6">

                                <div class="alert pds-tab permanent-address-tab-bg-color" role="alert">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Permanent Address</strong>
                                </div>

                                <div class="permanent-address-form">
                                    
                                    <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="per_room_num">Unit/Room No. Floor:</label>
                                            <input type="text" name="per_room_num" id="per_room_num" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Left Side -->
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            <label for="per_building_name">Building Name:</label>
                                            <input type="text" name="per_building_name" id="per_building_name" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="per_street">Street:</label>
                                            <input type="text" name="per_street" id="per_street" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="per_district">District:</label>
                                            <input type="text" name="per_district" id="per_district" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="per_province">Province:</label>
                                            <select name="per_province" id="per_province" class="form-control" onchange="getMunicipalities('per_region','per_province','per_municipality')" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                <option value="">Province</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="per_brgy">Barangay:</label>
                                            <select name="per_brgy" id="per_brgy" class="form-control" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                <option value="">Barangay</option>
                                            </select>
                                        </div>
                                    
                                    </div>

                                    <!-- Right Side -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="per_building_num">House/Bldg No:</label>
                                            <input type="text" name="per_building_num" id="per_building_num" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="per_subdivision">Subdivision/Village:</label>
                                            <input type="text" name="per_subdivision" id="per_subdivision" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="per_region">Region:</label>
                                            <select name="per_region" id="per_region" class="form-control" onchange="getProvinces('per_region','per_province')" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                <option value="">Region</option>
                                                <?php foreach($address -> getRegions() as $region) :?>
                                                <option value="<?php echo $region -> regCode;?>"><?php echo $region -> regDesc;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="per_municipality">Municipality:</label>
                                            <select name="per_municipality" id="per_municipality" class="form-control" onchange="getBarangays('per_region','per_province','per_municipality','per_brgy')" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                                <option value="">Municipality</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="per_zip_code">Zipcode:</label>
                                            <input type="text" name="per_zip_code" id="per_zip_code" class="form-control">
                                        </div>
                                    
                                    </div>
                                
                                    </div>
                                
                                </div>
                            
                            
                            </div>
                        
                        </div>
                    </div>
                    <!-- End of Address Tab -->


                    <!-- Family Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="family">
                        <div class="row">
                            
                            <div class="col-md-6">
                
                                <div class="alert pds-tab mother-tab-bg-color" role="alert">
                                    <i class="fa fa-female" aria-hidden="true"></i> <strong>Mother Information</strong>
                                </div>
                                
                                <div class="row">
                                
                                    <div class="mother-info-form">
                                        
                                        <!-- Left Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="mlname">Last Name:</label>
                                                <input type="text" class="form-control" id="mlname" name="mlname" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="mmname">Middle Name:</label>
                                                <input type="text" class="form-control" id="mmname" name="mmname">  
                                            </div>

                                            <div class="form-group">
                                                <label for="mbday">Birthday:</label>
                                                <input type="text" class="form-control" id="mbday" name="mbday">
                                            </div>

                                            <div class="form-group">
                                                <label for="mcontact">Contact Number:</label>
                                                <input type="text" class="form-control" id="mcontact" name="mcontact">
                                            </div>

                                            <div class="form-group">
                                                <label for="moccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="moccupation" name="moccupation" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>

                                        </div>

                                        <!-- Right Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="mfname">First Name:</label>
                                                <input type="text" class="form-control" id="mfname" name="mfname" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="msuffix">Suffix:</label>
                                                <select name="msuffix" id="msuffix" class="form-control">
                                                    <option value="">Suffix</option>
                                                    <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                                    <option value="<?php echo $suffix -> suffixdesc;?>"><?php echo $suffix -> suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="mage">Age:</label>
                                                <input type="text" class="form-control" id="mage" name="mage" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="mreligion">Religion:</label>
                                                <input type="text" class="form-control" id="mreligion" name="mreligion">
                                            </div>

                                            <div class="form-group">
                                                <label for="mnationality">Nationality:</label>
                                                <input type="text" class="form-control" id="mnationality" name="mnationality" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>

                                        </div>

                                    </div>

                                    
                                    <div class="spouse-info-form">

                                        <div class="col-md-12"  style="margin-top:20px;">
                                            <div class="alert pds-tab spouse-tab-bg-color" role="alert">
                                                <i class="fa fa-male" aria-hidden="true"></i> <strong>Spouse Information</strong>  <i class="fa fa-female" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        
                                        <!-- Left Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="slname">Last Name:</label>
                                                <input type="text" class="form-control" id="slname" name="slname">
                                            </div>

                                            <div class="form-group">
                                                <label for="smname">Middle Name:</label>
                                                <input type="text" class="form-control" id="smname" name="smname">
                                            </div>

                                            <div class="form-group">
                                                <label for="sbday">Birthday:</label>
                                                <input type="text" class="form-control" id="sbday" name="sbday">
                                            </div>

                                            <div class="form-group">
                                                <label for="ssalary">Salary:</label>
                                                <input type="text" class="form-control" id="ssalary" name="ssalary">
                                            </div>

                                        </div>

                                        <!-- Right Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="sfname">First Name:</label>
                                                <input type="text" class="form-control" id="sfname" name="sfname">
                                            </div>

                                            <div class="form-group">
                                                <label for="ssuffix">Suffix:</label>
                                                <select name="ssuffix"  class="form-control">
                                                    <option value="">Suffix</option>
                                                    <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                                    <option value="<?php echo $suffix -> suffixdesc;?>"><?php echo $suffix -> suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="sage">Age: </label>
                                                <input type="text" class="form-control" id="sage" name="sage" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="soccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="soccupation" name="soccupation">
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                

                            </div>

                            <div class="col-md-6">
                                
                                <div class="father-info-form">

                                    <div class="alert pds-tab father-tab-bg-color" role="alert">
                                        <i class="fa fa-male" aria-hidden="true"></i> <strong>Father Information</strong>
                                    </div>

                                    <div class="row">
                                        
                                        <!-- Left Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="flname">Last Name:</label>
                                                <input type="text" class="form-control" id="flname" name="flname" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="fmname">Middle Name:</label>
                                                <input type="text" class="form-control" id="fmname" name="fmname">
                                            </div>

                                            <div class="form-group">
                                                <label for="fbday">Birthday:</label>
                                                <input type="text" class="form-control" id="fbday" name="fbday">
                                            </div>

                                            <div class="form-group">
                                                <label for="fcontact">Contact Number: </label>
                                                <input type="text" class="form-control" id="fcontact" name="fcontact">
                                            </div>

                                            <div class="form-group">
                                                <label for="fnationality">Nationality: </label>
                                                <input type="text" class="form-control" id="fnationality" name="fnationality" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>
                                                
                                        </div>
                                        
                                        <!-- Right Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="ffname">First Name:</label>
                                                <input type="text" class="form-control" id="ffname" name="ffname" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="fsuffix">Suffix:</label>
                                                <select name="fsuffix" id="fsuffix" class="form-control">
                                                    <option value="">Suffix</option>
                                                    <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                                    <option value="<?php echo $suffix -> 
                                                    suffixdesc;?>"><?php echo $suffix -> suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="fage">Age:</label>
                                                <input type="text" class="form-control" id="fage" name="fage" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="freligion">Religion: </label>
                                                <input type="text" class="form-control" name="freligion" id="freligion">
                                            </div>

                                            <div class="form-group">
                                                <label for="foccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="foccupation" name="foccupation" oninvalid="errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);" required>
                                            </div>

                                        </div>
                                    
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- End of Family Tab -->


                    <!-- Children Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="children">
                        <div class="row">
                            
                            <div class="col-md-6">
                            
                                <div class="alert pds-tab children-tab-bg-color">
                                    <i class="fa fa-child" aria-hidden="true"></i> <strong>Children Information</strong>
                                </div>
                    
                                <div class="children-form">

                                    <div class="row">
                                        
                                        <!-- Left Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="clname">Last Name:</label>
                                                <input type="text" class="form-control" id="clname" name="clname">
                                            </div>

                                            <div class="form-group">
                                                <label for="cmname">Middle Name:</label>
                                                <input type="text" class="form-control" id="cmname" name="cmname">
                                            </div>

                                            <div class="form-group">
                                                <label for="cdob">Date of Birth:</label>
                                                <input type="text" class="form-control" id="cdob" name="cdob">
                                            </div>

                                            <div class="form-group">
                                                <label for="cpob">Place of Birth: </label>
                                                <input type="text" class="form-control" id="cpob" name="cpob">
                                            </div>

                                            <div class="form-group">
                                                <label for="coccupation">Occupation: </label>
                                                <input type="text" class="form-control" id="coccupation" name="coccupation">
                                            </div>

                                            <div class="form-group">
                                                <label for="cphysical">Physical Status: </label>
                                                <select name="cphysical" id="cphysical" class="form-control">
                                                    <option value="">Physical Status</option>
                                                    <?php foreach ($PDS -> getPhysicalStatusNames() as $physicalStatusData) :?>
                                                        <option value="<?php echo $physicalStatusData -> physical_status_name;?>"><?php echo $physicalStatusData -> physical_status_name;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="ceduclevel">Educational Level: </label>
                                                <select name="ceduclevel" id="ceduclevel" class="form-control">
                                                    <option value="">Level</option>
                                                    <option value="Elementary">Elementary</option>
                                                    <option value="Secondary">Secondary</option>
                                                    <option value="Vocational Trade Course">Vocational Trade Course</option>
                                                    <option value="College">College</option>
                                                    <option value="Graduate Studies">Graduate Studies</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                        
                                        <!-- Right Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="cfname">First Name:</label>
                                                <input type="text" class="form-control" id="cfname" name="cfname">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="csuffix">Suffix:</label>
                                                <select name="csuffix" id="csuffix" class="form-control">
                                                    <option value="">Suffix</option>
                                                    <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                                    <option value="<?php echo $suffix -> suffixdesc;?>"><?php echo $suffix -> suffixdesc;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="cgender">Age: </label>
                                                <input type="text" class="form-control" id="cage" name="cage" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="cgender">Gender: </label>
                                                <select name="cgender" id="cgender" class="form-control">
                                                    <option value="">Select Gender</option>
                                                    <option value="1">Male</option>
                                                    <option value="0">Female</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="coccupation">Salary: </label>
                                                <input type="text" class="form-control" id="csalary" name="csalary">
                                            </div>

                                            <div class="form-group">
                                                <label for="ccivilstatus">Civil Status: </label>
                                                <select name="ccivilstatus" id="ccivilstatus" class="form-control">
                                                    <option value="">Select Civil Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Widow">Widow</option>
                                                    <option value="Seperated">Seperated</option>
                                                    <option value="Annulled">Annulled</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="cschool">School: </label>
                                                <input type="text" class="form-control" id="cschool" name="cschool">
                                            </div>

                                        </div>

                                        <input type="hidden" class="form-control" id="child_id" name="child_id" value="">
                                        
                                        <div class="col-md-12 ">
                                            <div class="form-group pull-right">
                                                <button type="button" id="child_button" name="child_button" class="btn my-btn" onclick="addChild()"><i class="fa fa-plus"></i> New</button>
                                                <button type="button" id="cancel_child_btn" name="cancel_child_btn" class="btn my-btn" onclick="clearChild()"><i class="fa fa-times"></i> Cancel</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; List of Children</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="children_tbl_container">
                                            <table class="table table-striped" id="children_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Children Name</th>
                                                        <th class="text-center">Birthdate</th>
                                                        <th class="text-center">Age</th>
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
                    <!-- Children Tab -->
                    

                    <!-- Education Tab -->
                    <div role="tabpanel" class="tab-pane fade" id="education">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="alert pds-tab education-tab-bg-color">
                                <i class="fas fa-graduation-cap"></i> <strong>Educational Information</strong>
                            </div>
                            
                                <div class="educational-form">

                                    <div class="row">

                                        <!-- Left Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="educlevel">Educational Level:</label>
                                                <select name="educlevel" id="educlevel" class="form-control">
                                                    <option value="">Select Educational Level</option>
                                                    <option value="Elementary">Elementary</option>
                                                    <option value="Secondary">Secondary</option>
                                                    <option value="Vocational Trade Course">Vocational Trade Course</option>
                                                    <option value="College">College</option>
                                                    <option value="Graduate Studies">Graduate Studies</option>
                                                </select>
                                            </div>

                                        </div>

                                        <!-- Right Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="schooltype">School Type: </label>
                                                <select name="schooltype" id="schooltype" class="form-control">
                                                    <option value="">Select School Type</option>
                                                    <option value="Semi Public">Semi Public</option>
                                                    <option value="Public">Public</option>
                                                    <option value="Semi Private">Semi Private</option>
                                                    <option value="Private">Private</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="schoolname">Name of School:</label>
                                                <input type="text" class="form-control" id="schoolname" name="schoolname">
                                            </div>

                                            <div class="form-group">
                                                <label for="degreecourse">Degree Course: </label>
                                                <input type="text" class="form-control" id="degreecourse" name="degreecourse">
                                            </div>

                                        </div>

                                        <!-- Left Side -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="yeargraduated">Year Graduated: </label>
                                                <select name="yeargraduated" id="yeargraduated" class="form-control">
                                                    <option value="">Select Year Graduated</option>
                                                    <?php for($i=1900; $i <= date("Y"); $i++) :?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="graduatedfrom">Graduated From: </label>
                                                <input type="text" class="form-control" id="graduatedfrom" name="graduatedfrom">
                                            </div>
                                        </div>
                                        
                                        <!-- Right Side -->
                                        <div class="col-md-6">
                                        
                                            <div class="form-group">
                                                <label for="highestgrade">Highest Grade: </label>
                                                <input type="text" class="form-control" id="highestgrade" name="highestgrade">
                                            </div>  
                                            
                                            <div class="form-group">
                                                <label for="graduatedto">Graduated To: </label>
                                                <input type="text" class="form-control" id="graduatedto" name="graduatedto">
                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="scholarship">Scholarship/Honors Received: </label>
                                                <input type="text" class="form-control" id="scholarship" name="scholarship">
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" class="form-control" id="educ_id" name="educ_id" value="">

                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button type="button" id="educ_button" name="educ_button" class="btn my-btn" onclick="addEducation()"><i class="fa fa-plus"></i> New</button>
                                                <button type="button" id="cancel_educ_button" name="cancel_educ_button" class="btn my-btn" onclick="clearEducation()"><i class="fa fa-times"></i> Cancel</button>
                                            </div>
                                        </div>

                                    </div>

                                        

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; List of Educational Attainment</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id ="education_tbl_container">
                                            <table class="table table-striped" id="education_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Level</th>
                                                        <th class="text-center">Name of School</th>
                                                        <th class="text-center">Year</th>
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
                                <i class="fab fa-accessible-icon"></i> <strong>Trainings</strong>
                                </div>

                                <div class="training-form">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="seminar">Seminar/Workshop:</label>
                                                <input type="text" class="form-control" id="seminar" name="seminar">
                                            </div>
                                            
                                        </div>

                                        <!-- Left Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="seminardatefrom">Date From: </label>
                                                <input type="text" class="form-control" id="seminardatefrom" name="seminardatefrom">
                                            </div>

                                            <div class="form-group">
                                                <label for="seminarhours">Hours:</label>
                                                <input type="text" class="form-control" id="seminarhours" name="seminarhours">
                                            </div>

                                        </div>
                                        
                                        <!-- Right Side -->
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="seminardateto">Date To: </label>
                                                <input type="text" class="form-control" id="seminardateto" name="seminardateto">
                                            </div>    

                                            <div class="form-group">
                                                <label for="sponsoredby">Sponsored By: </label>
                                                <input type="text" class="form-control" id="sponsoredby" name="sponsoredby">
                                            </div>
                                        
                                        </div>
                                    
                                        <input type="hidden" class="form-control" id="training_id" name="training_id" value="">

                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button type="button" id="training_button" name="training_button" onclick="addTraining()" class="btn my-btn"><i class="fa fa-plus"></i> New</button>
                                                <button type="button" id="cancel_training_button" name="cancel_training_button" onclick="clearTraining()" class="btn my-btn"><i class="fa fa-times"></i> Cancel</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; List of Trainings Attainment</h3>
                                    </div>
                                    
                                    <div class="panel-body table-responsive">
                                        <div id="training_tbl_container">
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
                                    <i class="fa fa-check" style="color:#FFF;" aria-hidden="true"></i> <strong>Eligibility</strong>
                                </div>

                                <div class="eligibility-form">
                                    
                                    <div class="row">

                                    <!-- Left Side -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="career_services">Career Services:</label>
                                            <select name="career_services" id="career_services" class="form-control">
                                                <option value="">Select Career Service</option>
                                                <?php foreach ($PDS -> getCareerServices() as $careerService) :?>
                                                <option value="<?php echo $careerService -> careerservicedesc;?>"><?php echo $careerService -> careerservicedesc;?></option>
                                                <?php endforeach ;?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="examdate">Exam Date:</label>
                                            <input type="text" class="form-control" name="examdate" id="examdate">
                                        </div>

                                        <div class="form-group">
                                            <label for="licensenum">License Number:</label>
                                            <input type="text" class="form-control" name="licensenum" id="licensenum">
                                        </div>

                                    </div>

                                    <!-- Right Side -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="rating">Ratings:</label>
                                            <input type="text" class="form-control" name="rating" id="rating">
                                        </div>

                                        <div class="form-group">
                                            <label for="place">Place:</label>
                                            <input type="text" class="form-control" name="place" id="place">
                                        </div>

                                        <div class="form-group">
                                            <label for="licensedate">License Date:</label>
                                            <input type="text" class="form-control" name="licensedate" id="licensedate">
                                        </div>

                                    </div>

                                    <input type="hidden" class="form-control" id="eligibility_id" name="eligibility_id" value="">
                                    
                                    <div class="col-md-12">
                                        <div class="form-group pull-right">
                                            <button type="button" id="eligibility_button" name="eligibility_button" class="btn my-btn" onclick="addEligibility()"><i class="fa fa-plus"></i> New</button>
                                            <button type="button" id="cancel_eligibility_button" name="cancel_eligibility_button" class="btn my-btn" onclick="clearEligibility()"><i class="fa fa-times"></i> Cancel</button>
                                        </div>
                                    </div>

                                    </div>

                                </div>

                            </div>

                            
                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; List of Career Attainment</h3>
                                    </div>
                                    
                                    <div class="panel-body table-responsive">
                                        <div id="eligibility_tbl_container">
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
                                    <i class="fa fa-heartbeat" aria-hidden="true"></i> <strong>Surgery</strong>
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

                                    <div class="col-md-12 pad-3">
                                        <label for="career_services" class="col-sm-3 control-label">What Type of surgery?</label>
                                        <div class="col-sm-9 clr-gry">
                                            <div class="checkbox">
                                                <?php foreach($PDS -> getSurgeryTypes() as $surgerytype):?>
                                                <label><input type="checkbox" id="surgery_type" name="surgery_type[]"class="pds-checkbox" value="<?php echo $surgerytype -> id;?>"><?php echo $surgerytype -> surgtypedesc;?></label>
                                                <?php endforeach;?>
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

                                <div class="alert pds-tab organization-reference-tab-bg-color" role="alert">
                                    <i class="far fa-address-card" style="color:#FFF;"></i> <strong>Organization Reference</strong>
                                </div>

                                <div class="form-group text-center">
                                    <img src="/miaa/assets/images/hierarchy.svg" width="150" height="150" id="org_logo" name="org_logo">
                                </div>

                                <div class="form-group text-center">
                                    <label class="btn my-btn"><i class="far fa-file-image" aria-hidden="true"></i> Upload Organization Logo <input type="file" style="display: none;" name="org_img_file" id="org_img_file" onchange="readURL(this,'org_logo');" accept="image/x-png, image/gif, image/jpeg"></label>
                                </div>

                                <div class="org-reference-form">

                                    <div class="row">
                                
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="org_origin">Organization Origin:</label>
                                            <select name="org_origin" id="org_origin" class="form-control">
                                                <option value="">Select an Origin</option>
                                                <?php foreach($PDS -> getOrganizationOrigins() as $org_origin) :?>
                                                <option value="<?php echo $org_origin -> id;?>"><?php echo $org_origin -> orgorigindesc;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="org_name">Organization Name:</label>
                                            <input type="text" class="form-control" name="org_name" id="org_name">
                                        </div>

                                        <div class="form-group">
                                            <label for="org_purpose">Organization Purpose:</label>
                                            <input type="text" class="form-control" name="org_purpose" id="org_purpose">
                                        </div>
                                    
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="org_type">Organization Type:</label>
                                            <select name="org_type" id="org_type" class="form-control">
                                                <option value="">Select an Organization Type</option>
                                                <?php foreach ($PDS -> getOrganizationTypes() as $org_type):?>
                                                <option value="<?php echo $org_type -> id;?>"><?php echo $org_type -> orgtypedesc;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="org_status">Organization Status:</label>
                                            <input type="text" class="form-control" name="org_status" id="org_status">
                                        </div>

                                        <div class="form-group">
                                            <label for="org_position">Position:</label>
                                            <input type="text" class="form-control" name="org_position" id="org_position">
                                        </div>

                                    </div>

                                    </div>
                                    
                                </div>
                                
                            </div>


                            <div class="col-md-6">

                                <div class="alert pds-tab organization-address-tab-bg-color" role="alert">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Organization Address</strong>
                                </div>

                                <div class="org-address-form">
                                    
                                    <div class="row">
                                        
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="org_room_num">Unit/Room No. Floor:</label>
                                            <input type="text" name="org_room_num" id="org_room_num" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <!-- Left Side -->
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            <label for="org_building_name">Building Name:</label>
                                            <input type="text" name="org_building_name" id="org_building_name" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="org_street">Street:</label>
                                            <input type="text" name="org_street" id="org_street" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="org_district">District:</label>
                                            <input type="text" name="org_district" id="org_district" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="org_province">Province:</label>
                                            <select name="org_province" id="org_province" class="form-control"  onchange="getMunicipalities('org_region','org_province','org_municipality')">
                                                <option value=''>Province</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="org_brgy">Barangay:</label>
                                            <select name="org_brgy" id="org_brgy" class="form-control">
                                                <option value=''>Barangay</option>>
                                            </select>
                                        </div>
                                        
                                    </div>

                                    <!-- Right Side -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="org_building_num">House/Bldg No:</label>
                                            <input type="text" name="org_building_num" id="org_building_num" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="org_subdivision" >Subdivision/Village:</label>
                                            <input type="text" name="org_subdivision" id="org_subdivision" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="org_region">Region:</label>
                                            <select name="org_region" id="org_region" class="form-control" onchange="getProvinces('org_region','org_province')">
                                                <option value="">Region</option>
                                                <?php foreach($address -> getRegions() as $region) :?>
                                                <option value="<?php echo $region -> regCode;?>"><?php echo $region -> regDesc;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="org_municipality">Municipality:</label>
                                            <select name="org_municipality" id="org_municipality" class="form-control" onchange="getBarangays('org_region','org_province','org_municipality','org_brgy')">
                                                <option value=''>Municipality</option>
                                            </select>
                                        </div>

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


<?php include 'includes/footer.php';?>
<?php include 'includes/scripts.php';?>
<script src="<?=JS;?>gender/main-pds.js"></script>
<script src="<?=JS;?>gender/pds-webcam.js"></script>
<script src="<?=JS;?>gender/pds-address.js"></script>
<script src="<?=JS;?>gender/pds-org.js"></script>
<script src="<?=JS;?>gender/pds-children.js"></script>
<script src="<?=JS;?>gender/pds-education.js"></script>
<script src="<?=JS;?>gender/pds-trainings.js"></script>
<script src="<?=JS;?>gender/pds-eligibility.js"></script>
<script type="text/javascript">
$(document).ready(function () 
{   
    dateFormat('bday','age');
    dateFormat('mbday','mage');
    dateFormat('fbday','fage');
    dateFormat('sbday','sage');
    dateFormat('cdob','cage');
    dateFormat('graduatedfrom');
    dateFormat('graduatedto');
    dateFormat('seminardatefrom');
    dateFormat('seminardateto');
    dateFormat('examdate');
    dateFormat('licensedate');
    alertify.set('notifier','position', 'top-right');

    $(document).on('focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
});

//Start of Webcam Function
$('#webcam-button').click(function() {
    start();
    $('#webcam-modal').modal('show'); 
});

$('#employee_id').keyup(checkIfEmployeeIdExists);

$('#save_pds_btn').click(savePds);

$('#cancel_pds_btn').click(cancelPds);
</script>

