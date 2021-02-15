<?php 
require_once '../core/init.php';

use Gender\Classes\UserAudit;

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Input;

use Gender\Classes\References\Pds\PdsMain;
use Gender\Classes\References\Pds\Child;
use Gender\Classes\References\Pds\Education;
use Gender\Classes\References\Pds\Training;
use Gender\Classes\References\Pds\Eligibility;
use Gender\Classes\References\Pds\UserPds;
use Gender\Classes\References\Pds\PdsTransaction;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $pds = new PdsMain;
    $pds_child = new Child;
    $pds_education = new Education;
    $pds_training = new Training;
    $pds_eligibility = new Eligibility;
    $pds_trans = new PdsTransaction;

    $user_pds = new UserPds;
    $user_audit = new UserAudit;

    $user_audit->log(
        17, // Menu ID - Personal Data Sheet
        8 // Action ID - Add
    );

    $post_data = [
        'module_id' => Session::get('SESS_MODULE_CODE'),
        'prefix' => post('prefix'),
        'lname' => post('lname'),
        'fname' => post('fname'),
        'mname' => post('mname'),
        'suffix' => post('suffix'),
        'source_id' => post('source'),
        'pds_type_id' => post('pds_type'),
        'empno' => post('employee_id'),
        'passcode' => post('passenger_id'),
        'concode' => post('concessionaire_id'),
        'visitcode' => post('visitor_id'),
        'height' => post('height'),
        'weight' => post('weight'),
        'bloodtype' => post('blood_type'),
        'sex' => post('gender'),
        'genderpref' => post('gender_pref'),
        'cstatus' => post('civil_status'),
        'bdate' => post('bday'),
        'pbirth' => post('pob'),
        'nationality' => post('nationality'),
        'religion' => post('religion'),
        'celno' => post('phone'),
        'cp_country_code' => post('cp_country_code'),
        'telno' => post('telephone'),
        'email' => post('email'),
        'emptype' => post('employment_type'),
        'posncode' => post('position'),
        'office' => post('office'),
        'department' => post('department'),
        'division' => post('division'),
        'gsisno' => post('gsis'),
        'pagibigno' => post('pagibig'),
        'philhealthno' => post('philhealth'),
        'sssno' => post('sss'),
        'tin' => post('tin'),
        'voters_id' => post('voter_id_num'),
        'cscid' => post('csc_id_num'),
        'nbi_id' => post('nbi_id_num'),
        'cpname' => post('cpname'),
        'cprelationship' => post('cprelationship'),
        'cpcontactnum' => post('cpcontactnum'),
        'res_room_num' => post('res_room_num'),
        'res_building_name' => post('res_building_name'),
        'res_building_num' => post('res_building_num'),
        'res_street' => post('res_street'),
        'res_subdivision' => post('res_subdivision'),
        'res_district' => post('res_district'),
        'res_regncode' => post('res_region'),
        'res_provcode' => post('res_province'),
        'res_municode' => post('res_municipality'),
        'res_brgycode' => post('res_brgy'),
        'res_zipcode' => post('res_zip_code'),
        'mmaidenname' => post('mmaidenname'),
        'mlname' => post('mlname'),
        'mfname' => post('mfname'),
        'mmname' => post('mmname'),
        'msuffix' => post('msuffix'),
        'mbday' => post('mbday'),
        'mcontact' => post('mcontact'),
        'mreligion' => post('mreligion'),
        'mnationality' => post('mnationality'),
        'moccupation' => post('moccupation'),
        'flname' => post('flname'),
        'ffname' => post('ffname'),
        'fmname' => post('fmname'),
        'fsuffix' => post('fsuffix'),
        'fbday' => post('fbday'),
        'fcontact' => post('fcontact'),
        'freligion' => post('freligion'),
        'fnationality' => post('fnationality'),
        'foccupation' => post('foccupation'),
        'slname' => post('slname'),
        'sfname' => post('sfname'),
        'smname' => post('smname'),
        'ssuffix' => post('ssuffix'),
        'sbday' => post('sbday'),
        'sreligion' => post('sreligion'),
        'soccupation' => post('soccupation'),
        'ssalary' => post('ssalary'),
        'snationality' => post('snationality'),
        'org_room_num' => post('org_room_num'),
        'org_building_name' => post('org_building_name'),
        'org_building_num' => post('org_building_num'),
        'org_street' => post('org_street'),
        'org_subdivision' => post('org_subdivision'),
        'org_district' => post('org_district'),
        'org_regncode' => post('org_region'),
        'org_provcode' => post('org_province'),
        'org_municode' => post('org_municipality'),
        'org_brgycode' => post('org_brgy'),
        'org_zipcode' => post('org_zip_code'),
        'org_origin' => post('org_origin'),
        'org_type' => post('org_type'),
        'org_name' => post('org_name'),
        'org_status' => post('org_status'),
        'org_purpose' => post('org_purpose'),
        'org_position' => post('org_position')
    ];

    if (Input::get('use_same_address') === 'on') {
        $permanent_address = fill_permanent_address('res');
    }
    else {
        $permanent_address = fill_permanent_address('per');
    }

    $data = array_merge($post_data,$permanent_address);

    $pds->save($data);

    $pds_id = $pds->latestID();

    $pds->saveImage(Input::get('person_blob_img'),$pds->latestID());

    $children = json_decode($_POST['child_table_data'],true);

    if (count($children) > 0) {
        foreach ($children as $child) {
            $child += ['pds_id' => $pds_id];
            $pds_child->save($child);
        }
    }

    $educations = json_decode($_POST['educ_table_data'],true);

    if (count($educations) > 0) {
        foreach ($educations as $education) {
            $education += ['pds_id' => $pds_id];
            $pds_education->save($education);
        }
    }

    $trainings = json_decode($_POST['training_table_data'],true);

    if (count($trainings) > 0) {
        foreach ($trainings as $training) {
            $training += ['pds_id' => $pds_id];
            $pds_training->save($training);
        }
    }

    $eligibilities = json_decode($_POST['eligibility_table_data'],true);

    if (count($eligibilities) > 0) {
        foreach ($eligibilities as $eligibility) {
            $eligibility += ['pds_id' => $pds_id];
            $pds_eligibility->save($eligibility);
        }
    }

    $user_pds->save([
        'user_id' => Session::get('SESS_GENDER_USER_ID'),
        'pds_id' => $pds_id,
        'module_id' => Session::get('SESS_MODULE_CODE')
    ]);

    $pds_trans->save($pds_id,8); //Action Id = Save

    Session::put('successMsg','Personal Data Sheet Successfully Saved.');
    Redirect::to('pds/pds-list');
}
else {
    Redirect::to(404);
}