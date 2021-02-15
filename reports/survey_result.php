<?php 
require_once 'core/init.php';
require_once 'reports/tcpdf.php';

$survey_result = new SurveyResult;
$categories = new Category;

$survey_result -> surveyedEmployee($trans_id);
$empData = $survey_result -> employee();

class MYPDF extends TCPDF 
{
    public function Footer() 
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A3', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Survey Result');
$pdf->SetSubject('Survey Result');
$pdf->SetKeywords('Survey Result,PDF');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT+3, '15', PDF_MARGIN_RIGHT+5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();
$HTML='<style>
        .fw-b{
            font-weight:bold;
        }
        .text-center{
            text-align:center;
        }
        .fs-l{
            font-size:24px;
        }
        .survey-result-tbl{
            border:1px solid #000;
            border-collapse: collapse;
        }
        .survey-result-tbl td{
            border:1px solid #000;
        }
        </style>';
$HTML.='
    <p style="line-height:9px;">
        <h4 align="center" style="font-size:22px;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANILA INTERNATIONAL AIRPORT AUTHORITY
        </h4>
        <h4 align="center" style="font-size:22px;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM
        </h4>
        <h4 align="center" style="font-size:18px;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SURVEY RESULT
        </h4>
        <h3>________________________________________________________________________________________________________________________</h3>
    </p>';

$HTML.='<table cellpadding="4">
        <tr>
            <td class="fw-b" width="81%" style="font-size:15px;">Employee Name: '.$empData -> fname.' '.$empData -> mname.' '.$empData -> lname.' '.$empData -> suffix.'</td>
            <td class="fw-b" width="19%" style="font-size:15px;">Employee Id: '.$empData -> empno.'</td>
        </tr>
        <tr>
            <td class="fw-b" width="65%" style="font-size:15px;">Gender: '.gender($empData -> sex).'</td>
            <td class="fw-b" width="35%" style="font-size:15px;">Surveyed Date: '.pretty_date($empData -> survey_start).'</td>
        </tr>
        <tr><td></td></tr>
        
        </table>';

foreach ($categories -> lists() as $category) 
{
$HTML.='<table  cellpadding="10">
        <tr>
            <td class="fw-b text-center" width="100%" style="font-size:16px;">'.strtoupper($category -> categdesc).'</td>
        </tr>';
    $i = 1;
    foreach ($survey_result -> questionsByTransID($trans_id,$category -> id) as $question)
    {
    $HTML.='<tr style="font-size:14px;">
                <td width="5%" class="text-center">'.$i++.'.)'.'</td>
                <td width="95%">'.$question -> questiondesc.' ?'.'</td>';
    $HTML .='</tr>';

        foreach ($survey_result -> choicesByTransID($trans_id,$question -> question_id) as $choice) 
        {
        $HTML.='<tr style="font-size:14px;">
                    <td width="5%" class="text-center"></td>
                    <td width="95%">- '.unanswered($choice -> answer).'</td>';
        $HTML .='</tr>';
        }
    }

}
$HTML.='</table>';


//Style for QRCODE
$style = array(
    'border' => 1,
    'vpadding' => 2,
    'hpadding' => 2,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, 
    'module_width' => 1, 
    'module_height' => 1 
);

$pdf->Image('reports/images/MNL LOGO.png', 18, 18, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 1,true, false, false);
$pdf->write2DBarcode($trans_id,'QRCODE,H', 247, 12, 30, 30, $style, '');
$pdf->writeHTML($HTML, true, false, true, false, '');
$pdf->lastPage();
$pdf->Output('Survey Result.pdf', 'I');

?>