<?php 

require_once '../core/init.php';

use Gender\Classes\Supports\Input;


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$img = Input::get('chart_base64');

    $img_parts = explode(';base64,',$img);

    $img_base64 = base64_decode(isset($img_parts[1]) ? $img_parts[1] : null);

	$pdf = new TCPDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetTitle('Test');
	$pdf->SetSubject('Test');
	$pdf->SetKeywords('Test','PDF');
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetMargins(PDF_MARGIN_LEFT+3, '15', PDF_MARGIN_RIGHT+5);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setPrintFooter(false);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$pdf->SetFont('helvetica', '', 9);
	$pdf->AddPage();

	$HTML ='
	    <p style="line-height:9px;">
	        <h4 align="center" style="font-size:30px;">
	            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANILA INTERNATIONAL AIRPORT AUTHORITY
	        </h4>
	        <h4 align="center" style="font-size:28px;">
	            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ARCHIVE SYSTEM
	        </h4><br>
	        <h3>_________________________________________________________________________________________________________________________________________________________________________________</h3>
	    </p>';

	$HTML.='<table>
	        <tr><td><br></td></tr>
	        <tr>
	            <td width="100%" align="center" style="font-weight:bold;font-size:22px;">
	            	dasdasdasdasdasd    
	            </td>
	        </tr><tr><td><br></td></tr></table>';

	$pdf->Image('@'.$img_base64, 18, 90, 380, 380, 'PNG', '', 'T', false, 300, '', false, false, 1,true, false, false);

	$pdf->writeHTML($HTML, true, false, true, false, '');
	$pdf->lastPage();
	$pdf->Output('TEST.pdf', 'I');



}
