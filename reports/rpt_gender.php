<?php 
require_once '../core/init.php';

use Gender\Classes\Gender;
use Gender\Classes\GenderPreference;
use Gender\Classes\SurveyResult;
use Gender\Classes\Category;

use Gender\Classes\Supports\Input;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{   
    $gender = new Gender;
    $gender_pref = new GenderPreference;
    $survey_result = new SurveyResult;
    $categories = new Category;
    $HTML = "";

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
    $HTML.='<style>
            .fw-b{
                font-weight:bold;
            }
            .text-center{
                text-align:center;
            }
            .fs-l{
                font-size:24px;
            }
            .gender-rpt-tbl{
                border:1px solid #000;
                border-collapse: collapse;
            }
            .gender-rpt-tbl td{
                border:1px solid #000;
            }
            </style>';

    switch (Input::get('report_name')) {
        
        case 'total_gender':
            $pdf->AddPage();
            $HTML.='
            <p style="line-height:9px;">
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANILA INTERNATIONAL AIRPORT AUTHORITY
                </h4>
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM
                </h4>
                <h3>________________________________________________________________________________________________________________________</h3>
            </p>';
            $HTML.='
                <table>
                <tr><td><br></td></tr>
                <tr>
                    <td width="100%" align="center" style="font-weight:bold;font-size:18px;">
                        TOTAL NUMBER OF RESPONDENTS  
                    </td>
                </tr><tr><td><br></td></tr>
                </table>';
            $HTML.='<table class="gender-rpt-tbl" cellpadding="10">';
            $sum = 0;
            foreach ($gender -> totalNumberPerGender() as $gender_part) 
            {
            $sum+= (int)$gender_part -> total;
            $HTML.='
                <tr>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">'.strtoupper($gender_part -> gender).'</td>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">'.$gender_part -> total.'</td>
                </tr>';
            }
            $HTML.='
                <tr>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">TOTAL</td>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">'.$sum.'</td>
                </tr>';
            $HTML.='</table>';

            $pdf->Image(IMAGES.'MNL LOGO.png', 18, 18, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 1,true, false, false);
            $pdf->writeHTML($HTML, true, false, true, false, '');
            $pdf->lastPage();
            $pdf->Output('Survey Result.pdf', 'I');
        break;

        case 'total_gender_pref':
            $pdf->AddPage();  
            $HTML.='
            <p style="line-height:9px;">
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANILA INTERNATIONAL AIRPORT AUTHORITY
                </h4>
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM
                </h4>
                <h3>________________________________________________________________________________________________________________________</h3>
            </p>';          
            $HTML.='
                <table>
                <tr><td><br></td></tr>
                <tr>
                    <td width="100%" align="center" style="font-weight:bold;font-size:18px;">
                        TOTAL NUMBER OF GENDER PREFERENCES
                    </td>
                </tr><tr><td><br></td></tr>
                </table>';
            $HTML.='<table class="gender-rpt-tbl" cellpadding="10">';
            $sum = 0;
            foreach ($gender_pref -> totalNumberPerGenderPreference() as $gender_pref_part) 
            {
            $sum+= (int)$gender_pref_part -> total;
            $HTML.='
                <tr>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">'.strtoupper($gender_pref_part -> genderdesc).'</td>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">'.$gender_pref_part -> total.'</td>
                </tr>';
            }
            $HTML.='
                <tr>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">TOTAL</td>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">'.$sum.'</td>
                </tr>';
            $HTML.='</table>';

            $pdf->Image(IMAGES.'MNL LOGO.png', 18, 18, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 1,true, false, false);
            $pdf->writeHTML($HTML, true, false, true, false, '');
            $pdf->lastPage();
            $pdf->Output('Survey Result.pdf', 'I');
        break;

        case 'gender_by_month':
            $pdf->AddPage(); 
            $HTML.='
            <p style="line-height:9px;">
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANILA INTERNATIONAL AIRPORT AUTHORITY
                </h4>
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM
                </h4>
                <h3>________________________________________________________________________________________________________________________</h3>
            </p>';           
            $HTML.='
                <table>
                <tr><td><br></td></tr>
                <tr>
                    <td width="100%" align="center" style="font-weight:bold;font-size:18px;">
                        TOTAL NUMBER OF RESPONDENTS BY BIRTH MONTH
                    </td>
                </tr><tr><td><br></td></tr>
                </table>';
            $HTML.='<table class="gender-rpt-tbl" cellpadding="10">';
            $HTML.='
                <tr>
                    <td class="fw-b text-center" width="50%" style="font-size:15px;">BIRTH MONTH</td>
                    <td class="fw-b text-center" width="25%" style="font-size:15px;">TOTAL MALE</td>
                    <td class="fw-b text-center" width="25%" style="font-size:15px;">TOTAL FEMALE</td>
                </tr>';
            foreach ($gender -> byBirthMonth() as $gender_part) 
            {
            $HTML.='
                <tr>
                    <td class="fw-b text-center" width="50%" style="font-size:14px;">'.ucfirst($gender_part -> birthmonth).'</td>
                    <td class="fw-b text-center" width="25%" style="font-size:14px;">'.$gender_part -> total_male.'</td>
                    <td class="fw-b text-center" width="25%" style="font-size:14px;">'.$gender_part -> total_female.'</td>
                </tr>';
            }
            $HTML.='</table>';

            $pdf->Image(IMAGES.'MNL LOGO.png', 18, 18, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 1,true, false, false);
            $pdf->writeHTML($HTML, true, false, true, false, '');
            $pdf->lastPage();
            $pdf->Output('Survey Result.pdf', 'I');
        break;

        case 'gender_pref_by_month':
            $pdf->AddPage('L', 'A3');
            $HTML.='
            <p style="line-height:9px;">
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANILA INTERNATIONAL AIRPORT AUTHORITY
                </h4>
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM
                </h4>
                <h3>_________________________________________________________________________________________________________________________________________________________________________________</h3>
            </p>';
            $HTML.='
                <table>
                <tr><td><br></td></tr>
                <tr>
                    <td width="100%" align="center" style="font-weight:bold;font-size:18px;">
                        TOTAL NUMBER OF GENDER PREFERENCE BY BIRTH MONTH
                    </td>
                </tr><tr><td><br></td></tr>
                </table>';
            $HTML.='<table class="gender-rpt-tbl" cellpadding="10">';
            $HTML.='
                <tr>
                    <td class="fw-b text-center" width="10%" style="font-size:14px;">Birth Month</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Masculine</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Feminine</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Gay</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Lesbian</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Bisexual</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Transgender</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Queer</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Questioning</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Intersex</td>
                    <td class="fw-b text-center" width="9%" style="font-size:14px;">Asexual</td>
                </tr>';
            foreach ($gender_pref -> byBirthMonth() as $gender_pref_part) 
            {
            $HTML.='
                <tr>
                    <td class="fw-b text-center" width="10%" style="font-size:13px;">'.ucfirst($gender_pref_part -> birthmonth).'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> masculine.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> feminine.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> gay.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> lesbian.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> bisexual.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> transgender.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> queer.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> questioning.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> intersex.'</td>
                    <td class="fw-b text-center" width="9%" style="font-size:13px;">'.$gender_pref_part -> asexual.'</td>
                </tr>';
            }
            $HTML.='</table>';

            $pdf->Image(IMAGES.'MNL LOGO.png', 18, 18, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 1,true, false, false);
            $pdf->writeHTML($HTML, true, false, true, false, '');
            $pdf->lastPage();
            $pdf->Output('Survey Result.pdf', 'I');
        break;

        case 'total_reponses_per_categ':
            $pdf->AddPage();
            $HTML.='
            <p style="line-height:9px;">
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MANILA INTERNATIONAL AIRPORT AUTHORITY
                </h4>
                <h4 align="center" style="font-size:22px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM
                </h4>
                <h3>________________________________________________________________________________________________________________________</h3>
            </p>';
            $HTML.='
                <table>
                <tr><td><br></td></tr>
                <tr>
                    <td width="100%" align="center" style="font-weight:bold;font-size:18px;">
                        GENDER SENSITIVITY RESPONSES PER CATEGORY   
                    </td>
                </tr><tr><td><br></td></tr>
                </table>';
            foreach ($categories -> list() as $category) 
            {
            $HTML.='<table  cellpadding="10">
                    <tr>
                        <td class="fw-b text-center" width="100%" style="font-size:16px;">'.strtoupper($category -> categdesc).'</td>
                    </tr>';
                $i = 1;
                foreach ($survey_result -> questionsByCategory($category -> id) as $question)
                {
                    $HTML.='<tr style="font-size:14px;" class="fw-b">
                                <td width="100%">'.$question -> questiondesc.' ?'.'</td>';
                    $HTML .='</tr>';

                    foreach ($survey_result -> answersTally($question -> question_id) as $answer) 
                    {
                        $HTML.='<tr style="font-size:14px;">
                                    <td width="2%" class="text-center"></td>
                                    <td width="98%">- '.choice_taken($answer -> answerdesc) .' - '.$answer -> total.'</td>';
                        $HTML .='</tr>';
                    }
                }

            }
            $HTML.='</table>';

            $pdf->Image(IMAGES.'MNL LOGO.png', 18, 18, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 1,true, false, false);
            $pdf->writeHTML($HTML, true, false, true, false, '');
            $pdf->lastPage();
            $pdf->Output('Survey Result.pdf', 'I');
        break;
    }
}
else {
    Redirect::to(404);
}







?>