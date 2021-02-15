<?php 

require_once '../core/init.php';

use Gender\Classes\Supports\Input;
use Gender\Classes\Supports\Redirect;
use Gender\Classes\Supports\Session;

use Gender\Classes\UserAudit;
use Gender\Classes\ReportTransaction;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$rpt_trans = new ReportTransaction;
	$user_audit = new UserAudit;

	$rpt_trans->save([
		'user_id' => Session::get('SESS_GENDER_USER_ID'),
		'report_title' => Input::get('rpt_title'),
		'ip_address' => get_ip_address(),
		'mac_address' => getMacAdd(),
		'server' => $_SERVER['SERVER_NAME'],
		'platform' => get_platform(),
		'browser' => get_user_browser()
	]);

    $rpt_trans_id = $rpt_trans->latestID();

    $user_audit->log(
	    8, // Menu ID - Reports Generator
	    16 // Action ID - Print
	);

	// Extend the TCPDF class to create custom Header and Footer
	class MYPDF extends TCPDF {

	    //Page header
	    public function Header() {
	        
	        // MIAA logo
	        $image_file = DR.IMAGES.'MNL LOGO.png';
	        
	        $this->Image($image_file, 17, 10, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

	        // Style for qrcode
	        $style = array(
	            'border' => 0,
	            'vpadding' => 'auto',
	            'hpadding' => 'auto',
	            'fgcolor' => array(0,0,0),
	            'bgcolor' => false, //array(255,255,255)
	            'module_width' => 1, // width of a single module in points
	            'module_height' => 1 // height of a single module in points
	        );

	        // Get the report trans_id by making it global
	        global $rpt_trans_id;

	        // Set the qrcode and assign the survey trans id to it
	        $this->write2DBarcode($rpt_trans_id, 'QRCODE,H', 258, 7, 30, 30, $style, '');

	        // Set header text
	        $html ='
	                <table border="0" style="font-size:20px;font-weight:bold;">
	                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANILA INTERNATIONAL AIRPORT</td></tr>
	                </table>';
	        
	        $html .='
	                <table border="0" style="font-size:18px;font-weight:bold;">
	                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM</td></tr>
	                </table>';
	       	
	        $this->writeHTMLCell($w = 0, $h = 0, $x = 62, $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);

	        // Add a horizontal Line
	        $style = array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
	        $this->Line(18, 30, 279, 30, $style);
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
	$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

	// Set document information
	$pdf->SetTitle(Input::get('rpt_title'));
	$pdf->SetSubject('Report');
	$pdf->SetKeywords('Report,PDF');
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

    /* Start of Pdf Chart */
    $pdf->AddPage();

    $img = Input::get('chart_base64');

    $img_parts = explode(';base64,',$img);

    $img_base64 = base64_decode(isset($img_parts[1]) ? $img_parts[1] : null);

    $pdf->Image('@'.$img_base64, 18, 40, 274, 274, 'PNG', '', 'T', false, 300, '', false, false, 1,true, false, false);
    /* End of Pdf Chart */


    /* Start of Pdf Table */
    $pdf->AddPage();

    /* Get the table labels of organization */
	function org_label() 
	{
	    if (Input::get('category') == "office") { return "OFFICE"; }
	    
	    if (Input::get('category') == 'department') { return "DEPT"; }
	    
	    if (Input::get('category') == 'division') { return "DIVI"; }
	}

    $HTML ='
	<style>
        
        .fw-b{
            font-weight:bold;
        }
        
        .fs-s{
            font-size:13px;
        }
        
        .fs-l{
			font-size:15px;
        }

        .my-tbl{
			border:1px solid #000;
			border-collapse: collapse;
        }
        
        .my-tbl td{
			border:1px solid #000;
		}

		.my-tbl th{
			border:1px solid #000;
		}

    </style>';

    $headers = json_decode($_POST['tbl_header'],true);
    $rows = json_decode($_POST['tbl_row'],true);
    $rows_total = json_decode($_POST['tbl_row_total'],true);

	$HTML .='<h3 align="center">'.Input::get('rpt_title').'<br></h3>';    

	$HTML .='
	<table class="my-tbl" cellpadding="10">
	<thead>
        <tr align="center">'; 

        foreach ($headers as $th) {
        	$HTML .='<th class="fw-b fs-s">'.$th.'</th>';
        }
    
    $HTML .='
    	</tr>
    </thead>
    <tbody>';

    switch (Input::get('report_name')) 
    {

    	case 'gender':

    		if ( (Input::get('category') == 'all') || (Input::get('source') == '2' && Input::get('category') != 'all') ) 
		    {
				foreach ($rows as $row) 
				{
					$HTML .='
					<tr align="center">
			            <td class="fw-b fs-s">'.$row['GENDER'].'</td>
			            <td class="fw-b fs-s">'.$row['TOTAL'].'</td>
		        	</tr>';    	
		        }
				
				$HTML .='<tr align="center">';

		        foreach ($rows_total as $row_total) {
		        	$HTML .='<td class="fw-b fs-l">'.$row_total.'</td>';
		        }

		        $HTML .='</tr>';
			}

			if (Input::get('source') == '1' && Input::get('category') != 'all') 
			{
				foreach ($rows as $row) 
				{
					$HTML .='
					<tr align="center">
			            <td class="fw-b fs-s">'.$row[org_label()].'</td>
			            <td class="fw-b fs-s">'.$row['MALE_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['FEMALE_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.intval($row['MALE_TOTAL'] + $row['FEMALE_TOTAL']).'</td>
		        	</tr>';    	
		        }
				
				$HTML .='<tr align="center">';

		        foreach ($rows_total as $row_total) {
		        	$HTML .='<td class="fw-b fs-l">'.$row_total.'</td>';
		        }

		        $HTML .='</tr>';
			}	

		break;

		case 'gender_pref':

    		if ( (Input::get('category') == 'all') || (Input::get('source') == '2' && Input::get('category') != 'all') ) 
		 	{
				foreach ($rows as $row) 
				{
					$HTML .='
					<tr align="center">
			            <td class="fw-b fs-s">'.$row['GENDERPREF'].'</td>
			            <td class="fw-b fs-s">'.$row['TOTAL'].'</td>
		        	</tr>';    	
		        }
				
				$HTML .='<tr align="center">';

		        foreach ($rows_total as $row_total) {
		        	$HTML .='<td width="50%" class="fw-b fs-l">'.$row_total.'</td>';
		        }

		        $HTML .='</tr>';
			}

			if (Input::get('source') == '1' && Input::get('category') != 'all') 
			{
				foreach ($rows as $row) 
				{
					$HTML .='
					<tr align="center">
			            <td class="fw-b fs-s">'.$row[org_label()].'</td>
			            <td class="fw-b fs-s">'.$row['MASCULINE_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['FEMININE_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['GAY_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['LESBIAN_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['BI_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['TRANS_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['QUEER_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['QUESTIONING_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['INTERSEX_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['ASEXUAL_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['ALLY_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.$row['PANSEXUAL_TOTAL'].'</td>
			            <td class="fw-b fs-s">'.intval(
			            	$row['MASCULINE_TOTAL'] + $row['FEMININE_TOTAL'] + $row['GAY_TOTAL'] + $row['LESBIAN_TOTAL'] + 
			            	$row['BI_TOTAL'] + $row['TRANS_TOTAL'] + $row['QUEER_TOTAL'] + $row['QUESTIONING_TOTAL'] + 
			            	$row['INTERSEX_TOTAL'] + $row['ASEXUAL_TOTAL'] + $row['ALLY_TOTAL'] + $row['PANSEXUAL_TOTAL'] 
			            	).'</td>
		        	</tr>';    	
		        }
				
				$HTML .='<tr align="center">';

		        foreach ($rows_total as $row_total) {
		        	$HTML .='<td class="fw-b fs-l">'.$row_total.'</td>';
		        }

		        $HTML .='</tr>';
			}

		break;

		case 'survey_analysis':

		break;

    }

	$HTML .='
	</tbody>   
	</table>';

    $pdf->writeHTML($HTML, true, false, false, false, '');
    $pdf->lastPage();
    $pdf->Output(Input::get('rpt_title').'.pdf', 'I');
}
else {
	Redirect::to(404);
}


