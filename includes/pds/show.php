<?php 
    require_once 'core/init.php';
    include 'includes/styles.php';
    include 'includes/navbar.php';
    
    $PDS = new PDS;
    $PDS -> find($empno);
    $data = $PDS -> data();

    $appNumber = $PDS -> appNumber($empno);

    $org = new Organization;
    $address = new Address;
?>

<div class="col-md-12">
<form action="lib/process_pds.php" method="POST" id="pds_form" enctype="multipart/form-data">
    <p class="text-right">
        <a href="pds-lists.php" class="btn my-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
    </p>
   
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title "><img src="/miaa/assets/images/employees/male_avatar.svg" class="user-icon">&nbsp; PDS Data<span class="pull-right"></h3>
        </div>
        <div class="panel-body">
            
        <div class="form-horizontal" style="margin-bottom:-15px;">

            <div class="container-fluid">
            
                <div class="row">

                    <div class="col-md-2">

                        <div class="form-group">

                            <div class="col-sm-12 pad-3 text-center">
                                <input type="text" class="form-control" id="appNumber" name="appNumber" value="<?php echo $appNumber;?>" readonly>
                                <label for="appNumber" style="margin-top:5px;">Application No:</label>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-9 pull-right">

                        <div class="form-group">

                            <div class="col-sm-2 pad-3 text-center">
                                <input type="text" class="form-control" id="employee_id" name="employee_id" value="<?php echo $empno;?>" readonly>
                                <label for="employee_id" style="margin-top:5px;">Employee ID</label>
                            </div>
                            
                            <div class="col-sm-2 pad-3 text-center">
                               <select name="prefix" id="prefix" class="form-control">
                                    <option value="">Prefix</option>
                                    <?php foreach ($PDS -> getPrefixes() as $prefix) :?>
                                    <option value="<?php echo $prefix -> prefixdesc;?>" <?php selected($data -> prefix,$prefix -> prefixdesc);?>><?php echo $prefix -> prefixdesc;?></option>
                                    <?php endforeach;?>
                                </select>
                                <label for="prefix" style="margin-top:5px;">Prefix</label>
                            </div>
                         
                            <div class="col-sm-2 pad-3 text-center">
                                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $data -> lname;?>">
                                <label for="lname" style="margin-top:5px;">Lastname</label>
                            </div>

                            <div class="col-sm-2 pad-3 text-center">
                                <input type="text" class="form-control" id="fname" name="fname"  value="<?php echo $data -> fname;?>">
                                <label for="fname" style="margin-top:5px;">Firstname</label>
                            </div>

                            <div class="col-sm-2 pad-3 text-center">
                                <input type="text" class="form-control" id="mname" name="mname" value="<?php echo $data -> mname;?>">
                                <label for="mname" style="margin-top:5px;">Middlename</label>
                            </div>

                            <div class="col-sm-2 pad-3 text-center">
                               <select name="suffix" id="suffix" class="form-control">
                                    <option value="">Suffix</option>
                                    <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                    <option value="<?php echo $suffix -> suffixdesc;?>" <?php selected($data -> suffix,$suffix -> suffixdesc);?>><?php echo $suffix -> suffixdesc;?></option>
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
            <li role="presentation" class="active"><a href="#information" aria-controls="information" role="tab" data-toggle="tab">Information</a></li>
            <li role="presentation"><a href="#address" aria-controls="address" role="tab" data-toggle="tab">Address</a></li>
            <li role="presentation"><a href="#family" aria-controls="family" role="tab" data-toggle="tab">Family</a></li>
            <li role="presentation"><a href="#children" aria-controls="children" role="tab" data-toggle="tab">Children</a></li>
            <li role="presentation"><a href="#education" aria-controls="education" role="tab" data-toggle="tab">Education</a></li>
            <li role="presentation"><a href="#trainings" aria-controls="trainings" role="tab" data-toggle="tab">Trainings</a></li>
            <li role="presentation"><a href="#eligibility" aria-controls="eligibility" role="tab" data-toggle="tab">Eligibility</a></li>
            <li role="presentation"><a href="#medical" aria-controls="medical" role="tab" data-toggle="tab">Medical</a></li>
            <li role="presentation"><a href="#organization" aria-controls="organization" role="tab" data-toggle="tab">Organization</a></li>
        </ul><br>

        <div class="tab-content">

            <!-- Information Tab -->
            <div role="tabpanel" class="tab-pane fade in active" id="information">
                <div class="row">
                
                    <div class="col-md-6">

                        <div class="alert personal-tab text-center pad-3" role="alert">
                            <i class="fa fa-user" aria-hidden="true"></i> <strong>Personal Information</strong>
                        </div>
                    
                        <div class="form-group text-center">
                            <img class="img-circle" src="<?php echo personImage($data -> photo,$data -> sex);?>" width="150" height="150">
                        </div><br>
                     
                        <div class="form-horizontal">

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="height" class="col-sm-4 control-label">Height(m):</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="height" name="height" value="<?php echo $data -> height;?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="width" class="col-sm-4 control-label">weight(kg):</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="weight" name="weight" value="<?php echo $data -> weight;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="blood_type" class="col-sm-4 control-label">Blood Type</label>
                                        <div class="col-sm-8">
                                            <select name="blood_type" id="blood_type" class="form-control">
                                                <option value="">Blood Type</option>
                                                <option value="O-positive" <?php selected($data -> bloodtype,'O-positive');?>>O-positive</option>
                                                <option value="O-negative" <?php selected($data -> bloodtype,'O-negative');?>>O-negative</option>
                                                <option value="A-positive" <?php selected($data -> bloodtype,'A-positive');?>>A-positive</option>
                                                <option value="A-negative" <?php selected($data -> bloodtype,'A-negative');?>>A-negative</option>
                                                <option value="B-positive" <?php selected($data -> bloodtype,'B-positive');?>>B-positive</option>
                                                <option value="B-negative" <?php selected($data -> bloodtype,'B-negative');?>>B-negative</option>
                                                <option value="AB-positive" <?php selected($data -> bloodtype,'AB-positive');?>>AB-positive</option>
                                                <option value="AB-negative" <?php selected($data -> bloodtype,'AB-negative');?>>AB-negative</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender" class="col-sm-4 control-label">Gender*</label>
                                        <div class="col-sm-8">
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="">Gender</option>
                                            <option value="1" <?php selected($data -> sex,1);?>>Male</option>
                                            <option value="0" <?php selected($data -> sex,0);?>>Female</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bday" class="col-sm-4 control-label">Birthday*</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="bday" name="bday" value="<?php echo $data -> bdate;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age" class="col-sm-4 control-label">Age:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="age" name="age" readonly value="<?php echo calculateAge($data -> bdate);?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="organization" class="col-sm-5 control-label ">Gender Preference:</label>
                                        <div class="col-sm-7">
                                        <select name="gender_pref" id="gender_pref" class="form-control">
                                            <option value="">Gender Preferences</option>
                                            <?php foreach ($PDS -> getGenderPreferences() as $genderpref) :?>
                                                <option value="<?php echo $genderpref -> id;?>" <?php selected($data -> genderpref,$genderpref -> id);?>><?php echo $genderpref -> genderdesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">Place of Birth:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="pob" name="pob" value="<?php echo $data -> pbirth;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employment_type" class="col-sm-5 control-label">Employment Type: </label>
                                        <div class="col-sm-7">
                                        <select name="employment_type" id="employment_type" class="form-control">
                                            <option value="">Employment Type</option>
                                            <?php foreach ($PDS -> getEmploymentTypes() as $employmentType) :?>
                                                <option value="<?php echo $employmentType -> typecode;?>" <?php selected($data -> emptype,$employmentType -> typecode);?>><?php echo $employmentType -> typedesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position" class="col-sm-4 control-label">Position: </label>
                                        <div class="col-sm-8">
                                        <select name="position" id="position" class="form-control">
                                            <option value="">Position</option>
                                            <?php foreach ($PDS -> getPositions() as $position) :?>
                                            <option value="<?php echo $position -> posncode;?>" <?php selected($data -> posncode,$position -> posncode);?>><?php echo $position -> posndesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="civil_status" class="col-sm-4 control-label">Civil Status:</label>
                                        <div class="col-sm-8">
                                        <select name="civil_status" id="civil_status" class="form-control">
                                            <option value="">Select Civil Status</option>
                                            <option value="Single" <?php selected($data -> cstatus,'Single');?>>Single</option>
                                            <option value="Married" <?php selected($data -> cstatus,'Married');?>>Married</option>
                                            <option value="Widow" <?php selected($data -> cstatus,'Widow');?>>Widow</option>
                                            <option value="Seperated" <?php selected($data -> cstatus,'Seperated');?>>Seperated</option>
                                            <option value="Annulled" <?php selected($data -> cstatus,'Annulled');?>>Annulled</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="col-sm-4 control-label ">Email Address: </label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $data -> email;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="col-sm-4 control-label">Phone #: </label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $data -> celno;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telephone" class="col-sm-4 control-label">Telephone #: </label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $data -> telno;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nationality" class="col-sm-4 control-label">Nationality: </label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo $data -> nationality;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="religion" class="col-sm-4 control-label ">Religion:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="religion" name="religion" value="<?php echo $data -> religion;?>">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Start of Webcam Modal -->
                        <div class="modal fade" id="webcam-modal" tabindex="-1" role="dialog" aria-labelledby="webcam-modalLabel">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="exampleModalLabel">Webcam</h4>
                                    </div>
                                <div class="modal-body">
                                    <img src="../../assets/images/evaluation_pics/webcam.svg" class="img-responsive" alt="webcam">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn my-btn" data-dismiss="modal">
                                        <i class="fa fa-times"></i> Close</button>
                                    <button type="button" class="btn my-btn"><i class="fa fa-camera" aria-hidden="true"></i> Take Snapshot</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Webcam Modal -->

                    </div>

                    <div class="col-md-6">

                        <!-- Start of Offices Tab -->
                        <div class="form-horizontal">
    
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="alert offices-tab text-center pad-3" role="alert">
                                    <i class="fas fa-briefcase"></i> <strong>Offices/Departments/Divisions</strong>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="office" class="col-sm-2 control-label">Offices: </label>
                                        <div class="col-sm-10">
                                        <select name="office" id="office" class="form-control">
                                            <option value="">Lists of Offices</option>
                                            <?php foreach($org -> offices() as $office):?>
                                            <option value="<?php echo $office -> offcode;?>" <?php echo selected($data -> office,$office -> offcode);?>><?php echo $office -> offdesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="department" class="col-sm-2 control-label">Departments: </label>
                                        <div class="col-sm-10">
                                        <select name="department" id="department" class="form-control">
                                            <option value="">Lists of Departments</option>
                                            <?php foreach($org -> getDepartmentsByOffice($data -> office) as $department):?>
                                            <option value="<?php echo $department -> deptcode;?>" <?php echo selected($data -> department,$department -> deptcode);?>><?php echo $department -> deptdesc;?></option>
                                            <?php endforeach;?>
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
                                            <?php foreach($org -> getDivisionsByDepartment($data -> department) as $division):?>
                                            <option value="<?php echo $division -> divcode;?>" <?php echo selected($data -> division,$division -> divcode);?>><?php echo $division -> divdesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                        </div>
                        <!-- End of Offices Tab -->
                     
                        <!-- Start of Government Credentials -->
                        <br>
                        <div class="form-horizontal">
    
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="alert goverment-person-tab text-center pad-3" role="alert">
                                    <i class="fas fa-building"></i> <strong>Government Credentials</strong>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gsis" class="col-sm-4 control-label">GSIS ID NO: </label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="gsis" name="gsis" value="<?php echo $data -> gsisno;?>" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pagibig" class="col-sm-4 control-label">PAGIBIG ID NO: </label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="pagibig" name="pagibig" value="<?php echo $data -> pagibigno;?>" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="philhealth" class="col-sm-3 control-label">PHILHEALTH NO: </label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="philhealth" name="philhealth" value="<?php echo $data -> philhealthno;?>" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" style="padding-left:3px;">
                                        <label for="sss" class="col-sm-3 control-label">SSS NO: </label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="sss" name="sss" value="<?php echo $data -> sssno;?>" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tin" class="col-sm-2 control-label">TIN NO: </label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" id="tin" name="tin" value="<?php echo $data -> tin;?>" pattern="\d*" oninvalid="this.setCustomValidity('Only Numbers Allowed'); errorBorder(this.id);" oninput="this.setCustomValidity(''); removeBorderError(this.id);">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                        </div>
                        <!-- End of Government Credentials -->

                        <br>
                        <div class="form-horizontal">
      
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="alert contact-person-tab text-center pad-3" role="alert">
                                    <i class="fa fa-phone" aria-hidden="true"></i> <strong>Contact Person Information</strong>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="cname" class="col-sm-1 control-label" style="margin-top:5px !important;">Name: </label>
                                        
                                        <div class="col-sm-3 pad-3 text-center">
                                            <input type="text" class="form-control" id="cplname" name="cplname" value="<?php echo $data -> cplname;?>">
                                            <label for="cplname" style="margin-top:5px;">Lastname</label>
                                        </div>

                                        <div class="col-sm-4 pad-3 text-center">
                                            <input type="text" class="form-control" id="cpfname" name="cpfname" value="<?php echo $data -> cpfname;?>">
                                            <label for="cpfname" style="margin-top:5px;">Firstname</label>
                                        </div>

                                        <div class="col-sm-2 pad-3 text-center">
                                            <input type="text" class="form-control" id="cpmname" name="cpmname" value="<?php echo $data -> cpmname;?>">
                                            <label for="cpmname" style="margin-top:5px;">Middlename</label>
                                        </div>

                                        <div class="col-sm-2 text-center" style="padding-left:0;padding-top:3px;">
                                            <select name="cpsuffix" id="cpsuffix" class="form-control">
                                                <option value="">Suffix</option>
                                                <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                                <option value="<?php echo $suffix -> suffixdesc;?>" <?php selected($data -> cpsuffix,$suffix -> suffixdesc);?>><?php echo $suffix -> suffixdesc;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <label for="cpsuffix" style="margin-top:5px;">Suffix</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6" style="padding-left:3px;">
                                    <div class="form-group">
                                        <label for="cprelationship" class="col-sm-4 control-label">Relationship: </label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="cprelationship" name="cprelationship" value="<?php echo $data -> cprelationship;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6" style="padding-left:3px;">
                                    <div class="form-group">
                                        <label for="cpcontactnum" class="col-sm-4 control-label">Contact #: </label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="cpcontactnum" name="cpcontactnum" value="<?php echo $data -> cpcontactnum;?>">
                                        </div>
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

                        <div class="alert residential-address-tab text-center pad-3" role="alert">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Residential Address</strong>
                        </div>

                        <div class="form-horizontal">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="res_room_num" class="col-sm-3 control-label">Unit/Room No. Floor:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="res_room_num" id="res_room_num" class="form-control" value="<?php echo $data -> res_room_num;?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_building_name" class="col-sm-4 control-label">Building Name:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="res_building_name" id="res_building_name" class="form-control" value="<?php echo $data -> res_building_name;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_building_num" class="col-sm-4 control-label">House/Bldg No:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="res_building_num" id="res_building_num" class="form-control" value="<?php echo $data -> res_building_num;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_street" class="col-sm-2 control-label">Street:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="res_street" id="res_street" class="form-control" value="<?php echo $data -> res_street;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_subdivision" class="col-sm-5 control-label">Subdivision/Village:</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="res_subdivision" id="res_subdivision" class="form-control" value="<?php echo $data -> res_subdivision?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_district" class="col-sm-2 control-label">District:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="res_district" id="res_district" class="form-control" value="<?php echo $data -> res_district;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_region" class="col-sm-3 control-label">Region:</label>
                                    <div class="col-sm-9">
                                    <select name="res_region" id="res_region" class="form-control">
                                        <option value="">Region</option>
                                        <?php foreach($address -> getRegions() as $region) :?>
                                        <option value="<?php echo $region -> regCode;?>" <?php echo selected($data -> res_regncode,$region -> regCode);?>><?php echo $region -> regDesc;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_province" class="col-sm-3 control-label">Province:</label>
                                    <div class="col-sm-9">
                                    <select name="res_province" id="res_province" class="form-control">
                                        <option value="">Province</option>
                                        <?php foreach ($address -> getProvinces($data -> res_regncode) as $province):?>
                                        <option value="<?php echo $province -> provCode ;?>" <?php echo selected($data -> res_provcode,$province -> provCode);?>><?php echo $province -> provDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_municipality" class="col-sm-4 control-label">Municipality:</label>
                                    <div class="col-sm-8">
                                    <select name="res_municipality" id="res_municipality" class="form-control">
                                        <option value=''>Municipality</option>
                                        <?php foreach ($address -> getMunicipalities($data -> res_regncode,$data -> res_provcode) as $municipal):?>
                                        <option value="<?php echo $municipal -> cityMunCode ;?>" <?php echo selected($data -> res_municode,$municipal -> cityMunCode);?>><?php echo $municipal -> cityMunDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_brgy" class="col-sm-3 control-label">Barangay:</label>
                                    <div class="col-sm-9">
                                    <select name="res_brgy" id="res_brgy" class="form-control">
                                        <option value=''>Barangay</option>
                                        <?php foreach ($address -> getBarangays($data -> res_regncode,$data -> res_provcode,$data -> res_municode) as $barangay):?>
                                        <option value="<?php echo $barangay -> brgyCode ;?>" <?php echo selected($data -> res_brgycode,$barangay -> brgyCode);?>><?php echo $barangay -> brgyDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_zip_code" class="col-sm-3 control-label">Zipcode:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="res_zip_code" id="res_zip_code" class="form-control" value="<?php echo $data -> res_zipcode;?>">
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        
                    </div>

                    <div class="col-md-6">

                        <div class="alert permanent-address-tab text-center pad-3" role="alert">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Permanent Address</strong>
                        </div>

                        <div class="form-horizontal">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="per_room_num" class="col-sm-3 control-label">Unit/Room No. Floor:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="per_room_num" id="per_room_num" class="form-control" value="<?php echo $data -> per_room_num;?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_building_name" class="col-sm-4 control-label">Building Name:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="per_building_name" id="per_building_name" class="form-control" value="<?php echo $data -> per_building_name;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_building_num" class="col-sm-4 control-label">House/Bldg No:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="per_building_num" id="per_building_num" class="form-control" value="<?php echo $data -> per_building_num;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_street" class="col-sm-2 control-label">Street:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="per_street" id="per_street" class="form-control" value="<?php echo $data -> per_street;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_subdivision" class="col-sm-5 control-label">Subdivision/Village:</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="per_subdivision" id="per_subdivision" class="form-control" value="<?php echo $data -> per_subdivision;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_district" class="col-sm-2 control-label">District:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="per_district" id="per_district" class="form-control" value="<?php echo $data -> per_district;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_region" class="col-sm-3 control-label">Region:</label>
                                    <div class="col-sm-9">
                                    <select name="per_region" id="per_region" class="form-control">
                                        <option value="">Region</option>
                                        <?php foreach($address -> getRegions() as $region) :?>
                                        <option value="<?php echo $region -> regCode;?>" <?php echo selected($data -> per_regncode,$region -> regCode);?>><?php echo $region -> regDesc;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_province" class="col-sm-3 control-label">Province:</label>
                                    <div class="col-sm-9">
                                    <select name="per_province" id="per_province" class="form-control">
                                        <option value="">Province</option>
                                        <?php foreach ($address -> getProvinces($data -> per_regncode) as $province):?>
                                        <option value="<?php echo $province -> provCode ;?>" <?php echo selected($data -> per_provcode,$province -> provCode);?>><?php echo $province -> provDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_municipality" class="col-sm-4 control-label">Municipality:</label>
                                    <div class="col-sm-8">
                                    <select name="per_municipality" id="per_municipality" class="form-control">
                                        <option value="">Municipality</option>
                                        <?php foreach ($address -> getMunicipalities($data -> per_regncode,$data -> per_provcode) as $municipal):?>
                                        <option value="<?php echo $municipal -> cityMunCode ;?>" <?php echo selected($data -> per_municode,$municipal -> cityMunCode);?>><?php echo $municipal -> cityMunDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_brgy" class="col-sm-3 control-label">Barangay:</label>
                                    <div class="col-sm-9">
                                    <select name="per_brgy" id="per_brgy" class="form-control">
                                        <option value="">Barangay</option>
                                        <?php foreach ($address -> getBarangays($data -> per_regncode,$data -> per_provcode,$data -> per_municode) as $barangay):?>
                                        <option value="<?php echo $barangay -> brgyCode ;?>" <?php echo selected($data -> per_brgycode,$barangay -> brgyCode);?>><?php echo $barangay -> brgyDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="per_zip_code" class="col-sm-3 control-label">Zipcode:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="per_zip_code" id="per_zip_code" class="form-control" value="<?php echo $data -> per_zipcode;?>">
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
                        <div class="form-horizontal">

                            <div class="alert mother-tab text-center pad-3" role="alert">
                                <i class="fa fa-female" aria-hidden="true"></i> <strong>Mother Information</strong>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label" style="margin-top:5px !important;">Name: </label>
                                    
                                    <div class="col-sm-3 pad-3 text-center">
                                        <input type="text" class="form-control" id="mlname" name="mlname" value="<?php echo $data -> mlname;?>">
                                        <label for="mlname" style="margin-top:5px;">Lastname</label>
                                    </div>

                                    <div class="col-sm-4 pad-3 text-center">
                                        <input type="text" class="form-control" id="mfname" name="mfname" value="<?php echo $data -> mfname;?>">
                                        <label for="mfname" style="margin-top:5px;">Firstname</label>
                                    </div>

                                    <div class="col-sm-2 pad-3 text-center">
                                        <input type="text" class="form-control" id="mmname" name="mmname" value="<?php echo $data -> mmname;?>">
                                        <label for="mmname" style="margin-top:5px;">Middlename</label>
                                    </div>

                                    <div class="col-sm-2 pad-3 text-center">
                                        <select name="msuffix" id="msuffix" class="form-control">
                                            <option value="">Suffix</option>
                                            <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                            <option value="<?php echo $suffix -> suffixdesc;?>" <?php echo selected($data -> msuffix,$suffix -> suffixdesc);?>><?php echo $suffix -> suffixdesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <label for="msuffix" style="margin-top:5px;">Suffix</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mbday" class="col-sm-3 control-label">Birthday: </label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="mbday" name="mbday" value="<?php echo $data -> mbday;?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="mage" class="col-sm-3 control-label">Age: </label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="mage" name="mage" readonly value="<?php echo calculateAge($data -> mbday);?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="mcontact" class="col-sm-3 control-label">Contact No.: </label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="mcontact" name="mcontact" value="<?php echo $data -> mcontact;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="mreligion" class="col-sm-3 control-label">Religion: </label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="mreligion" name="mreligion" value="<?php echo $data -> mreligion;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="mnationality" class="col-sm-4 control-label">Nationality: </label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="mnationality" name="mnationality" value="<?php echo $data -> mnationality;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="moccupation" class="col-sm-4 control-label">Occupation: </label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="moccupation" name="moccupation" value="<?php echo $data -> moccupation;?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-horizontal">

                            <div class="alert father-tab text-center pad-3" role="alert">
                                <i class="fa fa-male" aria-hidden="true"></i> <strong>Father Information</strong>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label" style="margin-top:5px !important;">Name: </label>
                                    
                                    <div class="col-sm-3 pad-3 text-center">
                                        <input type="text" class="form-control" id="flname" name="flname" value="<?php echo $data -> flname;?>">
                                        <label for="flaname" style="margin-top:5px;">Lastname</label>
                                    </div>

                                    <div class="col-sm-4 pad-3 text-center">
                                        <input type="text" class="form-control" id="ffname" name="ffname" value="<?php echo $data -> ffname;?>">
                                        <label for="ffname" style="margin-top:5px;">Firstname</label>
                                    </div>

                                    <div class="col-sm-2 pad-3 text-center">
                                        <input type="text" class="form-control" id="fmname" name="fmname" value="<?php echo $data -> fmname;?>">
                                        <label for="fmname" style="margin-top:5px;">Middlename</label>
                                    </div>

                                    <div class="col-sm-2 pad-3 text-center">
                                        <select name="fsuffix" id="fsuffix" class="form-control">
                                            <option value="">Suffix</option>
                                            <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                            <option value="<?php echo $suffix -> 
                                            suffixdesc;?>" <?php echo selected($data -> fsuffix,$suffix -> suffixdesc);?>><?php echo $suffix -> suffixdesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <label style="margin-top:5px;">Suffix</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="fbday" class="col-sm-3 control-label">Birthday: </label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="fbday" name="fbday" value="<?php echo $data -> fbday;?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="fage" class="col-sm-3 control-label">Age: </label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="fage" name="fage" readonly value="<?php echo calculateAge($data -> fbday);?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="fcontact" class="col-sm-3 control-label">Contact No.: </label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="fcontact" name="fcontact" value="<?php echo $data -> fcontact;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Religion: </label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="freligion" name="freligion" value="<?php echo $data -> freligion;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="fnationality" class="col-sm-4 control-label">Nationality: </label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="fnationality" name="fnationality" value="<?php echo $data -> fnationality;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="foccupation" class="col-sm-4 control-label">Occupation: </label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" id="foccupation" name="foccupation" value="<?php echo $data -> foccupation;?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    
                    <div class="col-md-6">
                        <div class="form-horizontal">
      
                            <div class="row">

                                <div class="col-md-12 ">
                                    <div class="alert spouse-tab text-center pad-3" role="alert">
                                    <i class="fa fa-male" aria-hidden="true"></i> <strong>Spouse Information</strong>  <i class="fa fa-female" aria-hidden="true"></i>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" style="margin-top:5px !important;">Name: </label>
                                        
                                        <div class="col-sm-3 pad-3 text-center">
                                            <input type="text" class="form-control" id="slname" name="slname" value="<?php echo $data -> slname;?>">
                                            <label for="slname" style="margin-top:5px;">Lastname</label>
                                        </div>

                                        <div class="col-sm-4 pad-3 text-center">
                                            <input type="text" class="form-control" id="sfname" name="sfname" value="<?php echo $data -> sfname;?>">
                                            <label for="sfname" style="margin-top:5px;">Firstname</label>
                                        </div>

                                        <div class="col-sm-2 pad-3 text-center">
                                            <input type="text" class="form-control" id="smname" name="smname" value="<?php echo $data -> smname;?>">
                                            <label for="smname" style="margin-top:5px;">Middlename</label>
                                        </div>

                                        <div class="col-sm-2 text-center" style="padding-left:0;padding-top:3px;">
                                            <select name=""  class="form-control">
                                                <option value="">Suffix</option>
                                                <?php foreach ($PDS -> getSuffixes() as $suffix) :?>
                                                <option value="<?php echo $suffix -> suffixdesc;?>" <?php echo selected($data -> ssuffix,$suffix -> suffixdesc);?>><?php echo $suffix -> suffixdesc;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <label style="margin-top:5px;">Suffix</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sbday" class="col-sm-3 control-label">Birthday: </label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="sbday" name="sbday" value="<?php echo calculateAge($data -> sbday);?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sage" class="col-sm-3 control-label">Age: </label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="sage" name="sage" readonly value="<?php echo $data -> sbday;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="soccupation" class="col-sm-4 control-label">Occupation:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="soccupation" name="soccupation" value="<?php echo $data -> soccupation;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ssalary" class="col-sm-3 control-label">Salary: </label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="ssalary" name="ssalary" value="<?php echo $data -> ssalary;?>">
                                        </div>
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
                    
                    <div class="col-md-12">
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
                                                <th class="text-center">Place of Birth</th>
                                                <th class="text-center">Age</th>
                                                <th class="text-center">Gender</th>
                                                <th class="text-center">Civil Status</th>
                                                <th class="text-center">Physical Status</th>
                                                <th class="text-center">Educational Level</th>
                                                <th class="text-center">School</th>
                                                <th class="text-center">Occupation</th>
                                                <th class="text-center">Salary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $child = new Child;
                                        $i = 1;
                                        if ($child -> allData($appNumber)) :?>
                                        <?php foreach($child -> allData($appNumber) as $childData) :?>
                                        <tr class="text-center" id="childtr-<?php echo $childData -> id;?>">
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $childData -> fname.' '.$childData -> mname.' '.$childData -> lname.$childData -> suffix;?></td>    
                                            <td><?php echo $childData -> bdate;?></td>     
                                            <td><?php echo $childData -> pbirth;?></td>
                                            <td><?php echo calculateAge($childData -> bdate);?></td>
                                            <td><?php echo gender($childData -> sex);?></td>
                                            <td><?php echo $childData -> cstatus;?></td>
                                            <td><?php echo $childData -> physical_status;?></td>
                                            <td><?php echo $childData -> educ_level;?></td>
                                            <td><?php echo $childData -> school;?></td>
                                            <td><?php echo $childData -> occupation;?></td>  
                                            <td><?php echo $childData -> salary;?></td>          
                                        </tr>
                                        <?php endforeach ;?>
                                        <?php else :?>
                                        <tr class="text-center"><td colspan="12">No Data Found</td></tr>
                                        <?php endif ;?>
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

                    <div class="col-md-12">

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
                                                <th class="text-center">School Type</th>
                                                <th class="text-center">Degree</th>
                                                <th class="text-center">Attended From</th>
                                                <th class="text-center">Attended To</th>
                                                <th class="text-center">Grad Year</th>
                                                <th class="text-center">Highest Grade</th>
                                                <th class="text-center">Honor Received</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $education = new Education;
                                        $i = 1;
                                        if ($education -> allData($appNumber)) :?>
                                        <?php foreach($education -> allData($appNumber) as $educData) :?>
                                        <tr class="text-center">
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $educData -> level;?></td>    
                                            <td><?php echo $educData -> schlname;?></td>     
                                            <td><?php echo $educData -> school_type;?></td>
                                            <td><?php echo $educData -> degree;?></td>
                                            <td><?php echo $educData -> dateattdfrom;?></td>    
                                            <td><?php echo $educData -> dateattdto;?></td>
                                            <td><?php echo $educData -> gradyear;?></td>
                                            <td><?php echo $educData -> hgrade;?></td>
                                            <td><?php echo $educData -> honorrecvd;?></td>  
                                        </tr>
                                        <?php endforeach ;?>
                                        <?php else :?>
                                        <tr class="text-center"><td colspan="10">No Data Found</td></tr>
                                        <?php endif ;?>    
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
                                                <th class="text-center">Hours</th>
                                                <th class="text-center">Sponsored By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $training = new Training;
                                        $i = 1;
                                        if ($training -> allData($appNumber)) :?>
                                        <?php foreach($training -> allData($appNumber) as $trainData) :?>
                                        <tr class="text-center">
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $trainData -> sem_desc;?></td>    
                                            <td><?php echo $trainData -> incdatefrom;?></td>     
                                            <td><?php echo $trainData -> incdateto;?></td>
                                            <td><?php echo $trainData -> hourno;?></td>      
                                            <td><?php echo $trainData -> conspon;?></td>  
                                        </tr>
                                        <?php endforeach ;?> 
                                        <?php else :?>
                                        <tr class="text-center"><td colspan="6">No Data Found</td></tr>
                                        <?php endif ;?>
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
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-list" aria-hidden="true"></i>&nbsp; List of Career Attainment</h3>
                            </div>
                            
                            <div class="panel-body table-responsive">
                                <div id="eligibility_tbl_container">
                                    <table class="table table-striped" id="eligibility_tbl">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Career Service</th>
                                                <th class="text-center">Licence No.</th>
                                                <th class="text-center">Released</th>
                                                <th class="text-center">Exam Date</th>
                                                <th class="text-center">Place</th>
                                                <th class="text-center">Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $eligibility = new Eligibility;
                                        $i = 1;
                                        if ($eligibility -> allData($appNumber)) :?>
                                        <?php foreach($eligibility -> allData($appNumber) as $eligibData) :?>
                                        <tr class="text-center">
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $eligibData -> civildesc;?></td>    
                                            <td><?php echo $eligibData -> licno;?></td>     
                                            <td><?php echo $eligibData -> licdate;?></td>
                                            <td><?php echo $eligibData -> dateexam;?></td> 
                                            <td><?php echo $eligibData -> placeexam;?></td>     
                                            <td><?php echo $eligibData -> rating;?></td> 
                                        </tr>
                                        <?php endforeach ;?>
                                        <?php else:?>
                                        <tr class="text-center"><td colspan="7">No Data Found</td></tr> 
                                        <?php endif;?>
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
                        <div class="alert surgery-tab text-center pad-3" role="alert">
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
                                        <label><input type="checkbox" id="surgery_type" name="surgery_type[]"class="pds-checkbox" value="<?php echo $surgerytype -> id;?>"><?php echo $surgerytype -> surgtypedesc;?></label>&nbsp;
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
                    <div class="alert medical-history-tab text-center pad-3" role="alert">
                        <i class="fa fa-hospital" aria-hidden="true"></i> <strong>Medical History</strong>
                    </div>

                    <div class="form-horizontal">
                        
                        <div class="col-md-12 pad-3">
                            <div class="form-group">
                                <label class="col-sm-6 control-label">What type of surgery have you undergone?</label>
                                <div class="col-sm-6">
                                    <select name="" id="" class="form-control">
                                        <option value="">Medical Surgery</option>
                                        <option value="">Physical Improvements</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pad-3">
                            <div class="form-group">
                                <label class="col-sm-7 control-label">What kind of childhood illnesses do you experienced?</label>
                                <div class="col-sm-5">
                                    <select name="" id="" class="form-control">
                                        <option value="">Medical Surgery</option>
                                        <option value="">Physical Improvements</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>


                    </div>
                    
                </div>
            </div>
            <!-- End of Medical Tab -->


            <!-- Start of Organization Tab -->
            <div role="tabpanel" class="tab-pane fade" id="organization">
                <div class="row">
                    
                    <div class="col-md-6">

                        <div class="alert reference-tab text-center pad-3" role="alert">
                            <i class="far fa-address-card" style="color:#FFF;"></i> <strong>Organization Reference</strong>
                        </div>

                        <div class="form-group text-center">
                            <img src="<?php echo orgImage($data -> org_logo);?>" width="150" height="150" id="org_logo" name="org_logo">
                        </div>

                        <div class="form-group text-center">
                            <label class="btn my-btn" style="font-size:11px !important;"><i class="far fa-file-image" aria-hidden="true"></i> Upload Organization Logo <input type="file" style="display: none;" name="org_img_file" id="org_img_file" onchange="readURL(this,'org_logo');" accept="image/x-png, image/gif, image/jpeg"></label>
                        </div>

                        <div class="form-horizontal">
                        
                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="org_origin" class="col-sm-3 control-label">Org Origin:</label>
                                    <div class="col-sm-9">
                                        <select name="org_origin" id="org_origin" class="form-control">
                                            <option value="">Select an Origin</option>
                                            <?php foreach($PDS -> getOrganizationOrigins() as $org_origin) :?>
                                            <option value="<?php echo $org_origin -> id;?>" <?php selected($data -> org_origin,$org_origin -> id);?>><?php echo $org_origin -> orgorigindesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="org_type" class="col-sm-3 control-label">Org Type:</label>
                                    <div class="col-sm-9">
                                        <select name="org_type" id="org_type" class="form-control">
                                            <option value="">Select an Organization Type</option>
                                            <?php foreach ($PDS -> getOrganizationTypes() as $org_type):?>
                                            <option value="<?php echo $org_type -> id;?>" <?php selected($data -> org_type,$org_type -> id);?>><?php echo $org_type -> orgtypedesc;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="org_name" class="col-sm-3 control-label">Org Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="org_name" id="org_name" value="<?php echo $data -> org_name;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="org_status" class="col-sm-3 control-label">Org Status:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="org_status" id="org_status" value="<?php echo $data -> org_status;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="org_purpose" class="col-sm-4 control-label">Org Purpose:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="org_purpose" id="org_purpose" value="<?php echo $data -> org_purpose;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 pad-3">
                                <div class="form-group">
                                    <label for="org_position" class="col-sm-3 control-label">Position:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="org_position" id="org_position" value="<?php echo $data -> org_position;?>">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>

                    <div class="col-md-6">

                        <div class="alert organization-address-tab text-center pad-3" role="alert">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Organization Address</strong>
                        </div>

                        <div class="form-horizontal">
            
                            <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="org_room_num" class="col-sm-3 control-label">Unit/Room No. Floor:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="org_room_num" id="org_room_num" class="form-control" value="<?php echo $data -> org_room_num;?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_building_name" class="col-sm-4 control-label">Building Name:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="org_building_name" id="org_building_name" class="form-control" value="<?php echo $data -> org_building_name;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_building_num" class="col-sm-4 control-label">House/Bldg No:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="org_building_num" id="org_building_num" class="form-control" value="<?php echo $data -> org_building_num;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_street" class="col-sm-2 control-label">Street:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="org_street" id="org_street" class="form-control" value="<?php echo $data -> org_street;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_subdivision" class="col-sm-5 control-label">Subdivision/Village:</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="org_subdivision" id="org_subdivision" class="form-control" value="<?php echo $data -> org_subdivision?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_district" class="col-sm-2 control-label">District:</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="org_district" id="org_district" class="form-control" value="<?php echo $data -> org_district;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_region" class="col-sm-3 control-label">Region:</label>
                                    <div class="col-sm-9">
                                    <select name="org_region" id="org_region" class="form-control" onchange="getProvinces('org_region','org_province')">
                                        <option value="">Region</option>
                                        <?php foreach($address -> getRegions() as $region) :?>
                                        <option value="<?php echo $region -> regCode;?>" <?php echo selected($data -> org_regncode,$region -> regCode);?>><?php echo $region -> regDesc;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_province" class="col-sm-3 control-label">Province:</label>
                                    <div class="col-sm-9">
                                    <select name="org_province" id="org_province" class="form-control"  onchange="getMunicipalities('org_region','org_province','org_municipality')">
                                        <option value="">Province</option>
                                        <?php foreach ($address -> getProvinces($data -> org_regncode) as $province):?>
                                        <option value="<?php echo $province -> provCode ;?>" <?php echo selected($data -> org_provcode,$province -> provCode);?>><?php echo $province -> provDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="res_municipality" class="col-sm-4 control-label">Municipality:</label>
                                    <div class="col-sm-8">
                                    <select name="org_municipality" id="org_municipality" class="form-control" onchange="getBarangays('org_region','org_province','org_municipality','org_brgy')">
                                        <option value=''>Municipality</option>
                                        <?php foreach ($address -> getMunicipalities($data -> org_regncode,$data -> org_provcode) as $municipal):?>
                                        <option value="<?php echo $municipal -> cityMunCode ;?>" <?php echo selected($data -> org_municode,$municipal -> cityMunCode);?>><?php echo $municipal -> cityMunDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_brgy" class="col-sm-3 control-label">Barangay:</label>
                                    <div class="col-sm-9">
                                    <select name="org_brgy" id="org_brgy" class="form-control">
                                        <option value=''>Barangay</option>
                                        <?php foreach ($address -> getBarangays($data -> org_regncode,$data -> org_provcode,$data -> org_municode) as $barangay):?>
                                        <option value="<?php echo $barangay -> brgyCode ;?>" <?php echo selected($data -> org_brgycode,$barangay -> brgyCode);?>><?php echo $barangay -> brgyDesc ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="org_zip_code" class="col-sm-3 control-label">Zipcode:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="org_zip_code" id="org_zip_code" class="form-control" value="<?php echo $data -> org_zipcode;?>">
                                    </div>
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
    <br><br>
</form>
</div>

<?php include 'includes/footer.php';?>
<script type="text/javascript" src="../../assets/js/js-bootstrap/jquery.min.js"></script>
<script type="text/javascript" src="../../assets/js/js-bootstrap/bootstrap.min.js"></script>

<script type="text/javascript">
    $('input').attr('readonly', 'readonly');
    $('select').attr('disabled', 'disabled');
</script>


