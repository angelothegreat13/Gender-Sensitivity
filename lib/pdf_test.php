<?php

require_once '../core/init.php';


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

        $this->write2DBarcode(1821, 'QRCODE,H', 175, 7, 25, 25, $style, '');

        // $this->SetFont('helvetica', '');

        // Set header text
        $html = '
                <table border="0" style="font-size:20px;font-weight:bold;">
                    <tr><td>MANILA INTERNATIONAL AIRPORT</td></tr>
                </table>';
       
        $html .='
                <table border="0" style="font-size:18px;font-weight:bold;">
                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GENDER SENSITIVITY SYSTEM</td></tr>
                </table>';
       
        $this->writeHTMLCell($w = 0, $h = 0, $x = 62, $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);

        // Horizontal Line
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
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
$HTML = '';

$HTML .='<br><br><br>';

$HTML .='
    <table>
    <tr>
        <td width="100%" align="center" style="font-size:16px;letter-spacing:1px;">
            USER ANSWERS   
        </td>
    </tr>
    </table>';



$pdf->AddPage();
$pdf->writeHTML($HTML, true, false, true, false, '');
$pdf->Output('example_003.pdf', 'I');

