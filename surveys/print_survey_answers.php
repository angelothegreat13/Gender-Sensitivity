<?php 

require_once '../core/init.php';

use Gender\Classes\Answer;
use Gender\Classes\Choice;
use Gender\Classes\Category;
use Gender\Classes\Question;
use Gender\Classes\SurveyTransaction;
use Gender\Classes\UserSurveyTransaction;
use Gender\Classes\UserAudit;

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Session;
use Gender\Classes\Supports\Redirect;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$category = new Category;
	$question = new Question;
	$choice = new Choice;
    $answer = new Answer;
    $survey_trans = new SurveyTransaction;
    $user_survey_trans = new UserSurveyTransaction;
    $user_audit = new UserAudit;

    $survey_id = Input::get('survey_id');
    
    $survey_trans->save([
        'survey_id' => $survey_id,
        'action_id' => 13,
        'source_id' => Session::get('SESS_GENDER_SOURCE_ID'),
        'user_type_id' => Session::get('SESS_GENDER_USER_TYPE_ID'),
        'respondent_type_id' => Session::get('SESS_GENDER_RESPONDENT_TYPE_ID'),
        'ip_address' => get_ip_address(), 
        'mac_address' => getMacAdd(),
        'server' => $_SERVER['SERVER_NAME'],
        'browser' => get_user_browser(), 
        'platform' => get_platform()
    ]);

    $survey_trans_id = $survey_trans->latestID();

    $user_survey_trans->save([
        'survey_trans_id' => $survey_trans_id,
        'user_id' => Session::get('SESS_GENDER_USER_ID')
    ]);

    $user_audit->log(
	    12, // Menu ID - User Survey Answer
	    16 // Action ID - Print
	);

	// Extend the TCPDF class to create custom Header and Footer
	class MYPDF extends TCPDF {

	    //Page header
	    public function Header() {
	        
	        // Logo
	        $image_file = DR.IMAGES.'MNL LOGO.png';
	        
	        $this->Image($image_file, 17, 10, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

	        // New style for qrcode
	        $style = array(
	            'border' => 0,
	            'vpadding' => 'auto',
	            'hpadding' => 'auto',
	            'fgcolor' => array(0,0,0),
	            'bgcolor' => false, //array(255,255,255)
	            'module_width' => 1, // width of a single module in points
	            'module_height' => 1 // height of a single module in points
	        );

	        // Get the survey trans_id by making it global
	        global $survey_trans_id;

	        // Set the qrcode and assign the survey trans id to it
	        $this->write2DBarcode($survey_trans_id, 'QRCODE,H', 175, 7, 25, 25, $style, '');

	        // Set header text
	        $html ='
	                <table border="0" style="font-size:20px;font-weight:bold;">
	                    <tr><td>MANILA INTERNATIONAL AIRPORT</td></tr>
	                </table>';
	       
	        $html .='
	                <table border="0" style="font-size:18px;font-weight:bold;">
	                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM</td></tr>
	                </table>';
	       	
	        $this->writeHTMLCell($w = 0, $h = 0, $x = 62, $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);

	        // Add a horizontal Line
	        $style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
	        $this->Line(18, 30, 192, 30, $style);
	    }

	    // Page footer
	    public function Footer() {

	        // Position at 15 mm from bottom
	        $this->SetY(-15);

	        // Set font
	        $this->SetFont('helvetica', 'I', 8);

	        // Page number
	        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    }
	}

    // Create new PDF document
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// Set document information
	$pdf->SetTitle('Survey Answer');
	$pdf->SetSubject('Survey');
	$pdf->SetKeywords('Survey,Answer,PDF');
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// add an extra margin after the header
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 10, PDF_MARGIN_RIGHT);

	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->AddPage();


    $HTML ='';

    $HTML .='
    <style>
        .fw-b {
            font-weight:bold;
        }
        .text-center {
            text-align:center;
        }
    </style>';


    foreach ($category->list() as $categ_data) 
    {
    	$HTML .='
    	<table  cellpadding="10">
            <tr>
                <td class="fw-b text-center" width="100%" style="font-size:16px;">'.strtoupper($categ_data->categdesc).'</td>
            </tr>';

        $i = 1;
        
        foreach ($question->byCategory($categ_data->id) as $ques_data)
        {
            $HTML .='<tr style="font-size:14px;" class="fw-b">
                        <td width="100%">'.$i++.'.) '.$ques_data->questiondesc.' ?'.'</td>
    				</tr>';

            foreach ($answer->takenByUser($survey_id,$ques_data->id) as $answer_taken) 
            {
                $HTML .='<tr style="font-size:13px;">
                            <td width="2%"></td>
                            <td width="98%">- '.choice_taken($answer_taken->choicedesc).'</td>';
                $HTML .='</tr>';
            }
        }
		
	    $HTML .='</table>';
    	$HTML .='<br pagebreak="true"/>';
    }

    $pdf->writeHTML($HTML, true, false, true, false, '');

    $pdf->lastPage();

    // Delete the extra page
	$pdf->deletePage($pdf->getNumPages());

    $pdf->Output('Survey Answer.pdf', 'I');
}
else {
    Redirect::to(404);
}
