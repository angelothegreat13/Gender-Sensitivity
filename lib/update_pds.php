<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Input;

use Gender\Classes\References\Pds\PdsMain;
use Gender\Classes\References\Pds\PdsTransaction;

use Gender\Classes\UserAudit;

$user_audit = new UserAudit;
$pds_trans = new PdsTransaction;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $pds = new PdsMain;

    $post_data = [
        'prefix' => post('prefix'),
        'lname' => post('lname'),
        'fname' => post('fname'),
        'mname' => post('mname'),
        'suffix' => post('suffix'),
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

    $pds->update(post('pds_id'),$data);

    $pds->saveImage(Input::get('person_blob_img'),post('pds_id'));

    $user_audit->log(
        17, // Menu ID - Personal Data Sheet
        10 // Action ID - Update
    );

    $pds_trans->save(post('pds_id'),10); //Action Id = Update

    Session::put('successMsg','Personal Data Sheet Successfully Updated.');
    Redirect::to('pds/pds-list');
}
else {
    Redirect::to(404);
}