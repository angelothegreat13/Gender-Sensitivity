<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\References\Pds\Child;

if (Input::exists()) {

	$child = new Child;

	switch (Input::get('mode')) 
	{

		case 'add':

			$child->save([
				'pds_id' => Input::get('pds_id'),
                'lname' => Input::get('lastname'),
                'fname' => Input::get('firstname'),
                'mname' => Input::get('middlename'),
                'suffix' => Input::get('suffix'),
                'bdate' => Input::get('dob'),  
                'sex' => Input::get('gender'),
                'pbirth' => Input::get('pbirth'), 
                'occupation' => Input::get('occupation'), 
                'physical_status' => Input::get('physical'), 
                'cstatus' => Input::get('civilstatus'), 
                'educ_level' => Input::get('educlevel'), 
                'school' => Input::get('school'),
                'salary' => Input::get('salary')
			]);

			exitJson([
				'id' => $child->latestID(),
				'name' => Input::get('firstname').' '.Input::get('middlename').' '.Input::get('lastname').' '.Input::get('suffix'),
				'bday' => Input::get('dob')
			]);

		break;

		case 'edit':

			$id = Input::get('child_id');
			$child->find($id);
			$child_data = $child->data();

			exitJson([
				'id' => $id,
	            'firstname' => $child_data->fname,
	            'middlename' => $child_data->mname,
	            'lastname' => $child_data->lname,
	            'suffix' => $child_data->suffix,
	            'dob' => $child_data->bdate,
	            'pbirth' => $child_data->pbirth,
	            'gender' => $child_data->sex,
	            'cstatus' => $child_data->cstatus,
	            'occupation' => $child_data->occupation,
	            'physical_status' => $child_data->physical_status,
	            'educ_level' => $child_data->educ_level,
	            'school' => $child_data->school,
	            'salary' => $child_data->salary
			]);

		break;

		case 'update':

	        $child->update(Input::get('child_id'),[
	            'lname' => Input::get('lastname'),
	            'fname' => Input::get('firstname'),
	            'mname' => Input::get('middlename'),
	            'suffix' => Input::get('suffix'),
	            'bdate' => Input::get('dob'),  
	            'sex' => Input::get('gender'),
	            'pbirth' => Input::get('pbirth'), 
	            'occupation' => Input::get('occupation'), 
	            'physical_status' => Input::get('physical'), 
	            'cstatus' => Input::get('civilstatus'), 
	            'educ_level' => Input::get('educlevel'), 
	            'school' => Input::get('school'),
	            'salary' => Input::get('salary')    
	        ]);  
           
	        exitJson([
	           'id' => Input::get('child_id'),
	           'name' => Input::get('firstname').' '.Input::get('middlename').' '.Input::get('lastname').' '.Input::get('suffix'),
	           'bday' => Input::get('dob')
	        ]); 

		break;
		
		case 'delete':

			$id = Input::get('child_id');
			$child->delete($id);
			exitJson($id);

		break;

	}

}

