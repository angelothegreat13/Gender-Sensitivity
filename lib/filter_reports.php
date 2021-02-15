<?php 
require '../core/init.php';

use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Input;

use Gender\Classes\References\Pds\PdsReport;
use Gender\Classes\Answer;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$pds_report = new PdsReport;
	$answer = new Answer;

	$category = Input::get('category');
	$date_from = Input::get('date_from').' 00:00:00';
	$date_to = Input::get('date_to').' 23:59:59';

	switch (Input::get('report')) 
	{
		case 'gender':

			if ($category == 'all') {
				
				$data = $pds_report->totalNumberOfGenderBySource(
					Input::get('source'),
					$date_from,
					$date_to
				);
			
			}
			
			if (Input::get('source') == '1' && $category != 'all') {

				$data = $pds_report->totalNumberOfGenderPerOrganization(
					$category,
					$date_from,
					$date_to
				);
		
			}

			if (Input::get('source') == '2' && $category != 'all') {

				$data = $pds_report->totalNumberOfGenderByUserType(
					$category,
					$date_from,
					$date_to
				);

			}

			exitJson($data);

		break;


		case 'gender_pref':

			if ($category == 'all') {

				$data = $pds_report->totalNumberOfGenderPreferenceBySource(
					Input::get('source'),
					$date_from,
					$date_to
				);
		
			}

			if (Input::get('source') == '1' && $category != 'all') {

				$data = $pds_report->totalNumberOfGenderPreferenceByOrganization(
					$category,
					$date_from,
					$date_to
				);

			}

			if (Input::get('source') == '2' && $category != 'all') {

				$data = $pds_report->totalNumberOfGenderPreferenceByUserType(
					$category,
					$date_from,
					$date_to
				);

			}

			exitJson($data);

		break;

		case 'survey_analysis':

			if ($category == 'all') {

				$data = $answer->surveyAnalysisBySource(
					Input::get('source'),
					Input::get('survey_category'),
					$date_from,
					$date_to
				);
			
			}

			if (Input::get('source') == '1' && $category != 'all') {

				$data = $answer->surveyAnalysisPerOrganization(
					// $category,
					$date_from,
					$date_to
				);
				
			}

			if (Input::get('source') == '2' && $category != 'all') {

			}

			exitJson($data);

		break;

	}
}
else {
	Redirect::to(404);
}