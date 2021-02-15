<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\References\Pds\Eligibility;

if (Input::exists()) {

	$eligibility = new Eligibility;

	switch (Input::get('mode')) 
	{

		case 'add':

			$eligibility->save([
				'pds_id' => Input::get('pds_id'),
	            'civildesc' => Input::get('careerService'),
	            'rating' => Input::get('rating'),
	            'dateexam' => Input::get('examDate'),
	            'placeexam' => Input::get('place'),  
	            'licno' => Input::get('licenseNum'),
	            'licdate' => Input::get('licenseDate')
			]);

			exitJson([
				'id' => $eligibility->latestID(),
				'career' => Input::get('careerService'),
            	'license' => Input::get('licenseNum'),
            	'released' => Input::get('licenseDate')
			]);

		break;

		case 'edit':

			$id = Input::get('eligibility_id');
			$eligibility->find($id);
			$eligibility_data = $eligibility->data();

			exitJson([
				'id' => $id,
	            'careerService' => $eligibility_data->civildesc,
	            'rating' => $eligibility_data->rating,
	            'examDate' => $eligibility_data->dateexam,
	            'place' => $eligibility_data->placeexam,
	            'licenseNum' => $eligibility_data->licno,
	            'licenseDate' => $eligibility_data->licdate
			]);

		break;

		case 'update':

	        $eligibility->update(Input::get('eligibility_id'),[
	            'civildesc' => Input::get('careerService'),
	            'rating' => Input::get('rating'),
	            'dateexam' => Input::get('examDate'),
	            'placeexam' => Input::get('place'),  
	            'licno' => Input::get('licenseNum'),
	            'licdate' => Input::get('licenseDate')    
	        ]);  
           
	        exitJson([
		        'id' => Input::get('eligibility_id'),
		      	'career' => Input::get('careerService'),
            	'license' => Input::get('licenseNum'),
            	'released' => Input::get('licenseDate')
	        ]); 

		break;
		
		case 'delete':

			$id = Input::get('eligibility_id');
			$eligibility->delete($id);
			exitJson($id);

		break;

	}

}