<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\References\Pds\Education;

if (Input::exists()) {

	$education = new Education;

	switch (Input::get('mode')) 
	{

		case 'add':

			$education->save([
				'pds_id' => Input::get('pds_id'),
                'level' => Input::get('educLevel'),
                'schlname' => Input::get('schoolName'),
                'degree' => Input::get('degreeCourse'),
                'gradyear' => Input::get('yearGraduated'),  
                'hgrade' => Input::get('highestGrade'),
                'dateattdfrom' => Input::get('graduatedFrom'), 
                'dateattdto' => Input::get('graduatedTo'), 
                'honorrecvd' => Input::get('scholarship'),
                'school_type' => Input::get('schoolType')
			]);

			exitJson([
				'id' => $education->latestID(),
				'level' => Input::get('educLevel'),
            	'school' => Input::get('schoolName')
			]);

		break;

		case 'edit':

			$id = Input::get('education_id');
			$education->find($id);
			$education_data = $education->data();

			exitJson([
				'id' => $id,
	            'educLevel' => $education_data->level,
	            'schoolName' => $education_data->schlname,
	            'degreeCourse' => $education_data->degree,
	            'yearGraduated' => $education_data->gradyear,
	            'highestGrade' => $education_data->hgrade,
	            'graduatedFrom' => $education_data->dateattdfrom,
	            'graduatedTo' => $education_data->dateattdto,
	            'scholarship' => $education_data->honorrecvd,
	            'schoolType' => $education_data->school_type
			]);

		break;

		case 'update':

	        $education->update(Input::get('education_id'),[
	            'level' => Input::get('educLevel'),
	            'schlname' => Input::get('schoolName'),
	            'degree' => Input::get('degreeCourse'),
	            'gradyear' => Input::get('yearGraduated'),  
	            'hgrade' => Input::get('highestGrade'),
	            'dateattdfrom' => Input::get('graduatedFrom'), 
	            'dateattdto' => Input::get('graduatedTo'), 
	            'honorrecvd' => Input::get('scholarship'),
	            'school_type' => Input::get('schoolType')    
	        ]);  
           
	        exitJson([
		        'id' => Input::get('education_id'),
		        'level' => Input::get('educLevel'),
            	'school' => Input::get('schoolName')
	        ]); 

		break;
		
		case 'delete':

			$id = Input::get('education_id');
			$education->delete($id);
			exitJson($id);

		break;

	}






}