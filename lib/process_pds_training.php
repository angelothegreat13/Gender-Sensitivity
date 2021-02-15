<?php 
require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\References\Pds\Training;

if (Input::exists()) {

	$training = new Training;

	switch (Input::get('mode')) 
	{

		case 'add':

			$training->save([
				'pds_id' => Input::get('pds_id'),
                'sem_desc' => Input::get('seminar'),
                'incdatefrom' => Input::get('seminarDateFrom'),
                'incdateto' => Input::get('seminarDateTo'),
                'hourno' => Input::get('seminarHours'),  
                'conspon' => Input::get('sponsoredBy')
			]);

			exitJson([
				'id' => $training->latestID(),
				'seminar' => Input::get('seminar'),
            	'from' => Input::get('seminarDateFrom'),
            	'to' => Input::get('seminarDateTo')
			]);

		break;

		case 'edit':

			$id = Input::get('training_id');
			$training->find($id);
			$training_data = $training->data();

			exitJson([
				'id' => $id,
	            'seminar' => $training_data->sem_desc,
	            'seminarDateFrom' => $training_data->incdatefrom,
	            'seminarDateTo' => $training_data->incdateto,
	            'seminarHours' => $training_data->hourno,
	            'sponsoredBy' => $training_data->conspon
			]);

		break;

		case 'update':

	        $training->update(Input::get('training_id'),[
	            'sem_desc' => Input::get('seminar'),
	            'incdatefrom' => Input::get('seminarDateFrom'),
	            'incdateto' => Input::get('seminarDateTo'),
	            'hourno' => Input::get('seminarHours'),  
	            'conspon' => Input::get('sponsoredBy')    
	        ]);  
           
	        exitJson([
		        'id' => Input::get('training_id'),
		        'seminar' => Input::get('seminar'),
	            'from' => Input::get('seminarDateFrom'),
	            'to' => Input::get('seminarDateTo')
	        ]); 

		break;
		
		case 'delete':

			$id = Input::get('training_id');
			$training->delete($id);
			exitJson($id);

		break;

	}


}