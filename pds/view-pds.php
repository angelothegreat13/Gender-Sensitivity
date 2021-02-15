<?php 
require '../core/init.php';
include '../includes/styles.php';
include '../includes/navbar.php';

auth_guard();

use Gender\Classes\UserAudit;
use Gender\Classes\GenderPreference;

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Redirect;

use Gender\Classes\References\Address\Region;
use Gender\Classes\References\Address\Province;
use Gender\Classes\References\Address\Municipality;
use Gender\Classes\References\Address\Barangay;

use Gender\Classes\References\Settings\UserType;
use Gender\Classes\References\Settings\Source;

use Gender\Classes\References\Organizations\Office;
use Gender\Classes\References\Organizations\Department;
use Gender\Classes\References\Organizations\Division;
use Gender\Classes\References\Organizations\OrganizationType;

use Gender\Classes\References\Pds\PdsMain;
use Gender\Classes\References\Pds\PdsTransaction;
use Gender\Classes\References\Pds\Child;
use Gender\Classes\References\Pds\Education;
use Gender\Classes\References\Pds\Training;
use Gender\Classes\References\Pds\Eligibility;

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
	
$pds = new PdsMain;
$child = new Child;
$education = new Education;
$training = new Training;
$eligibility = new Eligibility;
$user_audit = new UserAudit;
$pds_trans = new PdsTransaction;
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
$department = new Department;
$division = new Division;
$region = new Region;
$province = new Province;
$municipality = new Municipality;
$barangay = new Barangay;
$physical_status = new PhysicalStatus;
$career_service = new CareerService;
$source = new Source;
$emp_type = new EmploymentType;
$org_type = new OrganizationType;


$pds_id = decrypt_url(Input::get('i'));
$pds->find($pds_id);
$pds_data = $pds->data();

if (!$pds_data) {
    Session::put('errorMsg','You cannot view inactive Personal Data Sheet');
    Redirect::back();
}

$user_audit->log(
    17, // Menu ID - Personal Data Sheet
    12 // Action ID - View
);

$pds_trans->save($pds_id,12); //Action Id = View

$children = $child->personChildren($pds_id);
$educations = $education->personEducations($pds_id);
$trainings = $training->personTrainings($pds_id);
$eligibilities = $eligibility->personEligibilities($pds_id);

?>

<link rel="stylesheet" href="<?=JS;?>intl-tel-input-master/build/css/intlTelInput.min.css">
<link rel="stylesheet" href="<?=ASSETS;?>templates/AdminLTE-master/bower_components/select2/dist/css/select2.min.css">

<div class="container-fluid">

    <div class="col-md-12">
        
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <img src="<?=IMAGES;?>employees/male_avatar.svg" class="mini-icon"> Personal Data Sheet Data
                <div class="pull-right">
                    <a href="<?=MODULE_URL;?>pds/pds-list.php" class="fs-16" data-toggle="tooltip" data-placement="top" title="Back to PDS table">
                        <i class="fa fa-arrow-left gamboge"></i> 
                    </a>
                </div>
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
                                        <option value="<?=$prefix_data->prefixdesc;?>" <?php selected($pds_data->prefix,$prefix_data->prefixdesc);?>>
                                        	<?=$prefix_data->prefixdesc;?>
                                    	</option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12 pds-top">
						            <input type="text" id="lname" name="lname" class="form-control" value="<?=$pds_data->lname;?>"placeholder="Last Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12 pds-top">
						            <input type="text" id="fname" name="fname" class="form-control" value="<?=$pds_data->fname;?>" placeholder="First Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12 pds-top">
						            <input type="text" id="mname" name="mname" class="form-control" value="<?=$pds_data->mname;?>" placeholder="Middle Name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
						            <select id="suffix" name="suffix" class="form-control">
                                        <option value="">Suffixes</option>
                                        <?php foreach ($suffix->list() as $suffix_data) :?>
                                        <option value="<?=$suffix_data->suffixdesc;?>" <?php selected($pds_data->suffix,$suffix_data->suffixdesc);?>>
                                        	<?=$suffix_data->suffixdesc;?>
                                        </option>
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
    		                                    <img class="img-circle" src="<?=avatar($pds_data->photo,$pds_data->sex);?>" width="150" height="150" id="person_img">
                            					<input type="hidden" name="person_blob_img" id="person_blob_img">
    		                                </div>
                                    	</div>

                                    </div>

                                    <div class="row">

                                        <input type="hidden" id="pds_id" name="pds_id" value="<?=$pds_id;?>">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pds_type">PDS Type:</label>
                                                <select id="pds_type" name="pds_type" class="form-control" disabled>
                                                    <option value="">PDS Types List:</option>	
                                                    <?php foreach ($user_type->list() as $user_type_data) :?>
                                                    <option value="<?=$user_type_data->id;?>" <?php selected($pds_data->pds_type_id,$user_type_data->id);?>>
                                                    	<?=$user_type_data->user_typedesc;?>
                                                    </option>
                                                    <?php endforeach;?>
						                        </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group cor-id-group">
                                                <label class="cor-id-label" for="select_input_id"><?=pds_correspanding_lbl($pds_data->pds_type_id);?> ID:</label> 
                                                <input type="text" class="form-control" value="<?=pds_correspanding_id($pds_data);?>" readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-4">
                                    		<div class="form-group">
                                                <label for="height">Height (m):</label>
                                                <input type="number" class="form-control" id="height" name="height" min="0" value="<?=$pds_data->height;?>">
                                            </div>
                                    	</div>
                                    	
                                    	<div class="col-md-4">
                                    		<div class="form-group">
                                                <label for="weight">Weight (kg):</label>
                                                <input type="number" class="form-control" id="weight" name="weight" min="0" value="<?=$pds_data->weight;?>">
                                            </div>
                                    	</div>
    									
    									<div class="col-md-4">
    										<div class="form-group">
                                                <label for="blood_type">Blood Type:</label>
                                                <select name="blood_type" id="blood_type" class="form-control">
                                                    <option value="">Blood Type</option>
                                                    <?php foreach ($blood_type->list() as $blood_type_data) :?>
                                                    <option value="<?=$blood_type_data->bloodtypedesc;?>" <?php selected($pds_data->bloodtype,$blood_type_data->bloodtypedesc);?>>
                                                        <?=$blood_type_data->bloodtypedesc;?></option>
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
                                                    <option value="Male" <?php selected($pds_data->sex,'Male');?>>Male</option>
                                                    <option value="Female" <?php selected($pds_data->sex,'Female');?>>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                        	<div class="form-group">
                                        		<label for="organization">Gender Preference:</label>
                                                <select name="gender_pref" id="gender_pref" class="form-control">
                                                    <option value="">Gender Preferences</option>
                                                    <?php foreach ($gender_pref->list() as $genderpref_data) :?>
                                                        <option value="<?=$genderpref_data->id;?>" <?php selected($pds_data->genderpref,$genderpref_data->id);?>>
                                                            <?=$genderpref_data->genderdesc;?>
                                                        </option>
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
                                                    <option value="<?=$civil_status_data->civilstatusdesc;?>" <?php selected($pds_data->cstatus,$civil_status_data->civilstatusdesc);?>>
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
                                                <label for="bday">Birthday:</label>
                                                <input type="text" class="form-control" id="bday" name="bday" value="<?=$pds_data->bdate;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                        	<div class="form-group">
                                                <label for="pob">Place of Birth:</label>
                                                <input type="text" class="form-control" id="pob" name="pob" value="<?=$pds_data->pbirth;?>">
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
                                                    <option value="<?=$country_data->country_enNationality;?>" <?php selected($pds_data->nationality,$country_data->country_enNationality);?>>
                                                        <?=$country_data->country_enNationality;?></option>
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
    												<option value="<?=$religion_data->religiondesc;?>" <?php selected($pds_data->religion,$religion_data->religiondesc);?>>
                                                        <?=$religion_data->religiondesc;?></option>
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
                                                <input type="text" class="form-control" id="phone" name="phone" value="<?=$pds_data->celno;?>"> 
                                                <label id="phone-num-error" class="hide"></label> 
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="telephone">Telephone Number: </label>
                                                <input type="number" class="form-control" id="telephone" name="telephone" min="0" value="<?=$pds_data->telno;?>">
                                            </div>
                                    	</div>

                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="email">Email Address: </label>
                                                <input type="email" class="form-control" id="email" name="email" autocomplete="off" value="<?=$pds_data->email;?>">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="employment_type">Employment Type:</label>
                                                <select name="employment_type" id="employment_type" class="form-control">
                                                    <option value="">Employment Types</option>
                                                    <?php foreach ($emp_type->list() as $emp_type_data) :?>
                                                        <option value="<?=$emp_type_data->typecode;?>"  <?php selected($pds_data->emptype,$emp_type_data->typecode);?>>
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
                                                    <option value="<?=$position_data->posncode;?>" <?php selected($pds_data->posncode,$position_data->posncode);?>>
                                                        <?=$position_data->posndesc;?>
                                                    </option>
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
                                                        <option value="<?=$office_data->offcode;?>" <?php selected($pds_data->office,$office_data->offcode);?>>
                                                            <?=$office_data->offdesc;?>
                                                        </option>
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
                                                        <?php foreach($department->sort($pds_data->office) as $dept_data):?>
                                                        <option value="<?=$dept_data->deptcode;?>" <?php selected($pds_data->department,$dept_data->deptcode);?>>
                                                            <?=$dept_data->deptdesc;?>
                                                        </option>
                                                        <?php endforeach;?>
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
                                                        <?php foreach($division->sort($pds_data->department) as $div_data):?>
                                                        <option value="<?=$div_data->divcode;?>" <?php selected($pds_data->division,$div_data->divcode);?>>
                                                            <?=$div_data->divdesc;?>
                                                        </option>
                                                        <?php endforeach;?>
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
                                                <input type="text" class="form-control" id="gsis" name="gsis" value="<?=$pds_data->gsisno;?>">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="pagibig">PAGIBIG ID NO: </label>
                                                <input type="text" class="form-control" id="pagibig" name="pagibig" value="<?=$pds_data->pagibigno;?>">
                                            </div>
                                    	</div>

                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="philhealth">PHILHEALTH NO: </label>
                                                <input type="text" class="form-control" id="philhealth" name="philhealth" value="<?=$pds_data->philhealthno;?>">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="sss">SSS NO: </label>
                                                <input type="text" class="form-control" id="sss" name="sss" value="<?=$pds_data->sssno;?>">
                                            </div>
                                    	</div>
                                    
                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="tin">TIN NO: </label>
                                                <input type="text" class="form-control" id="tin" name="tin" value="<?=$pds_data->tin;?>">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="voter_id_num">VOTER ID NO: </label>
                                                <input type="text" class="form-control" id="voter_id_num" name="voter_id_num" value="<?=$pds_data->voters_id;?>">
                                            </div>
                                    	</div>

                                    </div>
            
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="csc_id_num">CSC ID NO: </label>
                                                <input type="text" class="form-control" id="csc_id_num" name="csc_id_num" value="<?=$pds_data->cscid;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nbi_id_num">NBI ID NO: </label>
                                                <input type="text" class="form-control" id="nbi_id_num" name="nbi_id_num" value="<?=$pds_data->nbi_id;?>">
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
                                    			<input type="text" class="form-control" id="cpname" name="cpname" value="<?=$pds_data->cpname;?>">
                                    		</div>
                                    	</div>
                                    
                                    </div>

                                    <div class="row">
                                    	
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="cprelationship">Relationship: </label>
                                                <input type="text" class="form-control" id="cprelationship" name="cprelationship" value="<?=$pds_data->cprelationship;?>">
                                            </div>
                                    	</div>

                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                                <label for="cpcontactnum">Contact Number: </label>
                                                <input type="number" class="form-control" id="cpcontactnum" name="cpcontactnum" min="0" value="<?=$pds_data->cpcontactnum;?>">
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
                                                <input type="text" name="res_room_num" id="res_room_num" class="form-control" value="<?=$pds_data->res_room_num;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_building_name">Building Name:</label>
                                                <input type="text" name="res_building_name" id="res_building_name" class="form-control" value="<?=$pds_data->res_building_name;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_building_num">House/Bldg No:</label>
                                                <input type="text" name="res_building_num" id="res_building_num" class="form-control" value="<?=$pds_data->res_building_num;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_street">Street:</label>
                                                <input type="text" name="res_street" id="res_street" class="form-control" value="<?=$pds_data->res_street;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_subdivision">Subdivision/Village:</label>
                                                <input type="text" name="res_subdivision" id="res_subdivision" class="form-control" value="<?=$pds_data->res_subdivision;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_district">District:</label>
                                                <input type="text" name="res_district" id="res_district" class="form-control" value="<?=$pds_data->res_district;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_region">Region:</label>
                                                <select name="res_region" id="res_region" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Region</option>
                                                    <?php foreach($region->list() as $region_data) :?>
                                                    <option value="<?=$region_data->regCode;?>" <?php selected($pds_data->res_regncode,$region_data->regCode);?>>
                                                        <?=$region_data->regDesc;?>
                                                    </option>
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
                                                    <?php foreach ($province->sort($pds_data->res_regncode) as $prov_data):?>
                                                    <option value="<?=$prov_data->provCode;?>" <?php selected($pds_data->res_provcode,$prov_data->provCode);?>>
                                                        <?=$prov_data->provDesc ;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_municipality">Municipality:</label>
                                                <select name="res_municipality" id="res_municipality" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Municipalities</option>
                                                    <?php foreach ($municipality->sort($pds_data->res_regncode,$pds_data->res_provcode) as $mun_data):?>
                                                    <option value="<?=$mun_data->cityMunCode ;?>" <?php selected($pds_data->res_municode,$mun_data->cityMunCode);?>>
                                                        <?=$mun_data->cityMunDesc;?>
                                                    </option>
                                                    <?php endforeach;?>
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
                                                    <?php foreach ($barangay->sort($pds_data->res_regncode,$pds_data->res_provcode,$pds_data->res_municode) as $brgy_data):?>
                                                    <option value="<?=$brgy_data->brgyCode ;?>" <?php selected($pds_data->res_brgycode,$brgy_data->brgyCode);?>>
                                                        <?=$brgy_data->brgyDesc ;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="res_zip_code">Zipcode:</label>
                                                <input type="text" name="res_zip_code" id="res_zip_code" class="form-control" value="<?=$pds_data->res_zipcode;?>">
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
                                                <input type="text" name="per_room_num" id="per_room_num" class="form-control" value="<?=$pds_data->per_room_num;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_building_name">Building Name:</label>
                                                <input type="text" name="per_building_name" id="per_building_name" class="form-control" value="<?=$pds_data->per_building_name;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_building_num">House/Bldg No:</label>
                                                <input type="text" name="per_building_num" id="per_building_num" class="form-control" value="<?=$pds_data->per_building_num;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_street">Street:</label>
                                                <input type="text" name="per_street" id="per_street" class="form-control" value="<?=$pds_data->per_street;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_subdivision">Subdivision/Village:</label>
                                                <input type="text" name="per_subdivision" id="per_subdivision" class="form-control" value="<?=$pds_data->per_subdivision;?>"> 
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_district">District:</label>
                                                <input type="text" name="per_district" id="per_district" class="form-control" value="<?=$pds_data->per_district;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_region">Region:</label>
                                                <select name="per_region" id="per_region" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Regions</option>
                                                    <?php foreach($region->list() as $region_data) :?>
                                                    <option value="<?=$region_data->regCode;?>" <?php selected($pds_data->per_regncode,$region_data->regCode);?>>
                                                        <?=$region_data->regDesc;?>
                                                    </option>
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
                                                    <?php foreach ($province->sort($pds_data->per_regncode) as $prov_data):?>
                                                    <option value="<?=$prov_data->provCode;?>" <?php selected($pds_data->per_provcode,$prov_data->provCode);?>>
                                                        <?=$prov_data->provDesc ;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_municipality">Municipality:</label>
                                                <select name="per_municipality" id="per_municipality" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value=''>Municipalities</option>
                                                    <?php foreach ($municipality->sort($pds_data->per_regncode,$pds_data->per_provcode) as $mun_data):?>
                                                    <option value="<?=$mun_data->cityMunCode ;?>" <?php selected($pds_data->per_municode,$mun_data->cityMunCode);?>>
                                                        <?=$mun_data->cityMunDesc;?>
                                                    </option>
                                                    <?php endforeach;?>
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
                                                    <?php foreach ($barangay->sort($pds_data->per_regncode,$pds_data->per_provcode,$pds_data->per_municode) as $brgy_data):?>
                                                    <option value="<?=$brgy_data->brgyCode ;?>" <?php selected($pds_data->per_brgycode,$brgy_data->brgyCode);?>>
                                                        <?=$brgy_data->brgyDesc ;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="per_zip_code">Zipcode:</label>
                                                <input type="text" name="per_zip_code" id="per_zip_code" class="form-control" value="<?=$pds_data->per_zipcode;?>">
                                            </div>
                                        </div>

                                    </div>
    
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
                                                <input type="text" class="form-control" id="mmaidenname" name="mmaidenname" value="<?=$pds_data->mmaidenname;?>">
                                            </div>
                                        </div>                           

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="mlname">Last Name:</label>
                                                    <input type="text" class="form-control" id="mlname" name="mlname" value="<?=$pds_data->mlname;?>">
                                                </div>
                                            </div>
                                        </div> 

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mfname">First Name:</label>
                                                <input type="text" class="form-control" id="mfname" name="mfname" value="<?=$pds_data->mfname;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mmname">Middle Name:</label>
                                                <input type="text" class="form-control" id="mmname" name="mmname" value="<?=$pds_data->mmname;?>">  
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
                                                    <option value="<?=$suffix_data->suffixdesc;?>" <?php selected($pds_data->msuffix,$suffix_data->suffixdesc);?>>
                                                        <?=$suffix_data->suffixdesc;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mbday">Birthday:</label>
                                                <input type="text" class="form-control" id="mbday" name="mbday" value="<?=$pds_data->mbday;?>">
                                            </div>
                                        </div>

                                    </div>  

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mcontact">Contact Number:</label>
                                                <input type="number" class="form-control" id="mcontact" name="mcontact" value="<?=$pds_data->mcontact;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="moccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="moccupation" name="moccupation" value="<?=$pds_data->moccupation;?>">
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
                                                    <option value="<?=$religion_data->religiondesc;?>" <?php selected($pds_data->mreligion,$religion_data->religiondesc);?>>
                                                        <?=$religion_data->religiondesc;?>
                                                    </option>
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
                                                    <option value="<?=$country_data->country_enNationality;?>" <?php selected($pds_data->mnationality,$country_data->country_enNationality);?>>
                                                        <?=$country_data->country_enNationality;?>
                                                    </option>
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
                                                <input type="text" class="form-control" id="slname" name="slname" value="<?=$pds_data->slname;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sfname">First Name:</label>
                                                <input type="text" class="form-control" id="sfname" name="sfname" value="<?=$pds_data->sfname;?>">
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="smname">Middle Name:</label>
                                                <input type="text" class="form-control" id="smname" name="smname" value="<?=$pds_data->smname;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ssuffix">Suffix:</label>
                                                <select name="ssuffix" id="ssuffix" class="form-control">
                                                    <option value="">Suffixes</option>
                                                    <?php foreach ($suffix->list() as $suffix_data) :?>
                                                    <option value="<?=$suffix_data->suffixdesc;?>" <?php selected($pds_data->ssuffix,$suffix_data->suffixdesc);?>>
                                                        <?=$suffix_data->suffixdesc;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sbday">Birthday:</label>
                                                <input type="text" class="form-control" id="sbday" name="sbday" value="<?=$pds_data->sbday;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sreligion">Religion:</label>
                                                <select class="form-control" id="sreligion" name="sreligion">
                                                    <option value="">Select a Religion</option>
                                                    <?php foreach ($religion->list() as $religion_data) :?>
                                                    <option value="<?=$religion_data->religiondesc;?>" <?php selected($pds_data->sreligion,$religion_data->religiondesc);?>>
                                                        <?=$religion_data->religiondesc;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="soccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="soccupation" name="soccupation" value="<?=$pds_data->soccupation;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ssalary">Salary:</label>
                                                <input type="number" class="form-control" id="ssalary" name="ssalary" value="<?=$pds_data->ssalary;?>">
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
                                                    <option value="<?=$country_data->country_enNationality;?>" <?php selected($pds_data->snationality,$country_data->country_enNationality);?>>
                                                        <?=$country_data->country_enNationality;?>
                                                    </option>
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
                                                <input type="text" class="form-control" id="flname" name="flname" value="<?=$pds_data->flname;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ffname">First Name:</label>
                                                <input type="text" class="form-control" id="ffname" name="ffname" value="<?=$pds_data->ffname;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fmname">Middle Name:</label>
                                                <input type="text" class="form-control" id="fmname" name="fmname" value="<?=$pds_data->fmname;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fsuffix">Suffix:</label>
                                                <select id="fsuffix" name="fsuffix" class="form-control">
                                                    <option value="">Suffixes</option>
                                                    <?php foreach ($suffix->list() as $suffix_data) :?>
                                                    <option value="<?=$suffix_data->suffixdesc;?>" <?php selected($pds_data->fsuffix,$suffix_data->suffixdesc);?>>
                                                        <?=$suffix_data->suffixdesc;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fbday">Birthday:</label>
                                                <input type="text" class="form-control" id="fbday" name="fbday" value="<?=$pds_data->fbday;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fcontact">Contact Number: </label>
                                                <input type="number" class="form-control" id="fcontact" name="fcontact" value="<?=$pds_data->fcontact;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="foccupation">Occupation:</label>
                                                <input type="text" class="form-control" id="foccupation" name="foccupation" value="<?=$pds_data->foccupation;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="freligion">Religion: </label>
                                                <select class="form-control" id="freligion" name="freligion">
                                                    <option value="">Select a Religion</option>
                                                    <?php foreach ($religion->list() as $religion_data) :?>
                                                    <option value="<?=$religion_data->religiondesc;?>" <?php selected($pds_data->freligion,$religion_data->religiondesc);?>>
                                                        <?=$religion_data->religiondesc;?>
                                                    </option>
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
                                                    <option value="<?=$country_data->country_enNationality;?>" <?php selected($pds_data->fnationality,$country_data->country_enNationality);?>>
                                                        <?=$country_data->country_enNationality;?>
                                                    </option>
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
                        
                            <!-- Start of Children Table -->
                            <div class="col-md-12">

                                <div class="panel panel-default">
                                    
                                    <div class="panel-heading fs-13">
                                        <i class="fas fa-list my-green" aria-hidden="true"></i> Children List
                                    </div>

                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="children_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Birthdate</th>
                                                        <th class="text-center">Place of Birth</th>
                                                        <th class="text-center">Gender</th>
                                                        <th class="text-center">Civil Status</th>
                                                        <th class="text-center">Occupation</th>
                                                        <th class="text-center">Physical Status</th>
                                                        <th class="text-center">Education Level</th>
                                                        <th class="text-center">School</th>
                                                        <th class="text-center">Salary</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                $ci = 1;
                                                foreach ($children as $child_data) :?>
                                                    <tr class="text-center" id="child-tr-<?=$child_data->id;?>">    
                                                        <td><?=$ci++;?></td>
                                                        <td><?=$child_data->fname.' '.$child_data->lname.' '.$child_data->mname.' '.$child_data->suffix;?></td>
                                                        <td><?=$child_data->bdate;?></td>
                                                        <td><?=$child_data->pbirth;?></td>
                                                        <td><?=$child_data->sex;?></td>
                                                        <td><?=$child_data->cstatus;?></td>
                                                        <td><?=$child_data->occupation;?></td>
                                                        <td><?=$child_data->physical_status;?></td>
                                                        <td><?=$child_data->educ_level;?></td>
                                                        <td><?=$child_data->school;?></td>
                                                        <td><?=$child_data->salary;?></td>
                                                    </tr>
                                                <?php endforeach;?>
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

                            <div class="col-md-12">

                                <div class="panel panel-default">
                                    
                                    <div class="panel-heading fs-13">
                                        <i class="fa fa-list my-green" aria-hidden="true"></i> List of Educational Attainment
                                    </div>
                                    
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="education_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Level</th>
                                                        <th class="text-center">School</th>
                                                        <th class="text-center">Degree</th>
                                                        <th class="text-center">Grad Year</th>
                                                        <th class="text-center">Highest Grade</th>
                                                        <th class="text-center">Date From</th>
                                                        <th class="text-center">Date To</th>
                                                        <th class="text-center">Honor Received</th>
                                                        <th class="text-center">School Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                $ei = 1;
                                                foreach ($educations as $educ_data) :?>
                                                    <tr class="text-center" id="educ-tr-<?=$educ_data->id;?>">    
                                                        <td><?=$ei++;?></td>
                                                        <td><?=$educ_data->level;?></td>
                                                        <td><?=$educ_data->schlname;?></td>
                                                        <td><?=$educ_data->degree;?></td>
                                                        <td><?=$educ_data->gradyear;?></td>
                                                        <td><?=$educ_data->hgrade;?></td>
                                                        <td><?=$educ_data->dateattdfrom;?></td>
                                                        <td><?=$educ_data->dateattdto;?></td>
                                                        <td><?=$educ_data->honorrecvd;?></td>
                                                        <td><?=$educ_data->school_type;?></td>
                                                    </tr>
                                                <?php endforeach;?>
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

                            <div class="col-md-12">

                                <div class="panel panel-default">
                                    <div class="panel-heading fs-13">
                                        <i class="fas fa-list my-green" aria-hidden="true"></i> List of Trainings Attainment
                                    </div>
                                    
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="training_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Seminar/Workshop</th>
                                                        <th class="text-center">Date From</th>
                                                        <th class="text-center">Date To</th>
                                                        <th class="text-center">Hours</th>
                                                        <th class="text-center">Sponsored By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                $ti = 1;
                                                foreach($trainings as $training_data) :?>
                                                <tr class="text-center" id="train-tr-<?=$training_data->id;?>">
                                                    <td><?=$ti++;?></td>
                                                    <td><?=$training_data->sem_desc;?></td>    
                                                    <td><?=$training_data->incdatefrom;?></td>     
                                                    <td><?=$training_data->incdateto;?></td>    
                                                    <td><?=$training_data->hourno;?></td>    
                                                    <td><?=$training_data->conspon;?></td>    
                                                </tr>
                                                <?php endforeach;?> 
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
                            
                            <div class="col-md-12">

                                <div class="panel panel-default">
                                    <div class="panel-heading fs-13">
                                        <i class="fa fa-list my-green" aria-hidden="true"></i> List of Career Attainment
                                    </div>
                                    
                                    <div class="panel-body table-responsive">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="eligibility_tbl">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No.</th>
                                                        <th class="text-center">Career</th>
                                                        <th class="text-center">Ratings</th>
                                                        <th class="text-center">Exam Date</th>
                                                        <th class="text-center">Place of Exam</th>
                                                        <th class="text-center">Licence No.</th>
                                                        <th class="text-center">Released</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                $ti = 1;
                                                foreach($eligibilities as $eligib_data) :?>
                                                <tr class="text-center" id="eligib-tr-<?=$eligib_data->id;?>">
                                                    <td><?=$ti++;?></td>
                                                    <td><?=$eligib_data->civildesc;?></td>
                                                    <td><?=$eligib_data->rating;?></td>
                                                    <td><?=$eligib_data->dateexam;?></td>
                                                    <td><?=$eligib_data->placeexam;?></td>
                                                    <td><?=$eligib_data->licno;?></td>
                                                    <td><?=$eligib_data->licdate;?></td>     
                                                </tr>
                                                <?php endforeach;?> 
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
                                                    <option value="<?=$source_data->id;?>" <?php selected($pds_data->org_origin,$source_data->id);?>>
                                                        <?=$source_data->sourcedesc;?>
                                                    </option>
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
                                                    <option value="<?=$org_type_data->id;?>" <?php selected($pds_data->org_type,$org_type_data->id);?>>
                                                        <?=$org_type_data->orgtypedesc;?>        
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_name">Organization Name:</label>
                                                <input type="text" class="form-control" name="org_name" id="org_name" value="<?=$pds_data->org_name;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_status">Organization Status:</label>
                                                <input type="text" class="form-control" name="org_status" id="org_status" value="<?=$pds_data->org_status;?>">
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
                                                    <option value="<?=$position_data->posncode;?>" <?php selected($pds_data->org_position,$position_data->posncode);?>>
                                                        <?=$position_data->posndesc;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="org_purpose">Organization Purpose:</label>
                                                <textarea name="org_purpose" id="org_purpose" rows="9" class="form-control"><?=$pds_data->org_purpose?></textarea>
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
                                                <input type="text" name="org_room_num" id="org_room_num" class="form-control" value="<?=$pds_data->org_room_num;?>">
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_building_name">Building Name:</label>
                                                <input type="text" name="org_building_name" id="org_building_name" class="form-control" value="<?=$pds_data->org_building_name;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_building_num">House/Bldg No:</label>
                                                <input type="text" name="org_building_num" id="org_building_num" class="form-control" value="<?=$pds_data->org_building_num;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_street">Street:</label>
                                                <input type="text" name="org_street" id="org_street" class="form-control" value="<?=$pds_data->org_street;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_subdivision" >Subdivision/Village:</label>
                                                <input type="text" name="org_subdivision" id="org_subdivision" class="form-control" value="<?=$pds_data->org_subdivision;?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_district">District:</label>
                                                <input type="text" name="org_district" id="org_district" class="form-control" value="<?=$pds_data->org_district;?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_region">Region:</label>
                                                <select name="org_region" id="org_region" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value="">Regions</option>
                                                    <?php foreach($region->list() as $region_data) :?>
                                                    <option value="<?=$region_data->regCode;?>" <?php selected($pds_data->org_regncode,$region_data->regCode);?>>
                                                        <?=$region_data->regDesc;?>
                                                    </option>
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
                                                    <?php foreach ($province->sort($pds_data->org_regncode) as $prov_data):?>
                                                    <option value="<?=$prov_data->provCode;?>" <?php selected($pds_data->org_provcode,$prov_data->provCode);?>>
                                                        <?=$prov_data->provDesc ;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        
                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="org_municipality">Municipality:</label>
                                                <select name="org_municipality" id="org_municipality" class="form-control select2-input-tag" style="width: 100%;">
                                                    <option value=''>Municipalities</option>
                                                    <?php foreach ($municipality->sort($pds_data->org_regncode,$pds_data->org_provcode) as $mun_data):?>
                                                    <option value="<?=$mun_data->cityMunCode ;?>" <?php selected($pds_data->org_municode,$mun_data->cityMunCode);?>>
                                                        <?=$mun_data->cityMunDesc;?>
                                                    </option>
                                                    <?php endforeach;?>
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
                                                    <?php foreach ($barangay->sort($pds_data->org_regncode,$pds_data->org_provcode,$pds_data->org_municode) as $brgy_data):?>
                                                    <option value="<?=$brgy_data->brgyCode ;?>" <?php selected($pds_data->org_brgycode,$brgy_data->brgyCode);?>>
                                                        <?=$brgy_data->brgyDesc ;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="org_zip_code">Zipcode:</label>
                                                <input type="text" name="org_zip_code" id="org_zip_code" class="form-control" value="<?=$pds_data->org_zipcode;?>">
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

    </div>

</div>


<?php 
    include '../includes/footer.php';
    include '../includes/scripts.php';
?>
<script type="text/javascript">

$(document).ready(function() {
    
    $("body input").attr("readonly", "readonly");
    $("body select").attr("disabled", "disabled");
    $("body textarea").attr("readonly", "readonly");

    $("#children_tbl").DataTable();
    $("#education_tbl").DataTable();
    $("#training_tbl").DataTable();
    $("#eligibility_tbl").DataTable();

});

</script>

