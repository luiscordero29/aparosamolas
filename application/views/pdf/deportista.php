<?php

tcpdf();  
// create new PDF document
class MYPDF extends TCPDF {

    //Page header
    public function Header() {              
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', '', 7);
        // Page number
        $this->Cell(0, 10, '', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$obj_pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$obj_pdf->SetCreator(PDF_CREATOR);
$obj_pdf->SetAuthor('APP - APA ROSA MOLAS');
$obj_pdf->SetTitle('INFORMACIÓN DEL DEPORTISTA');
$obj_pdf->SetSubject('APA ROSA MOLAS');
$obj_pdf->SetKeywords('APA ROSA MOLAS');

// set default header data
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$obj_pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$obj_pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$obj_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set default font subsetting mode
$obj_pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
// Add a page
// This method has several options, check the source code documentation for more information.
$obj_pdf->AddPage();



$obj_pdf->Image(base_url().'assets/images/logo.png', '75', '10', 60, 15, '', '', 'T', false, 100, '', false, false, 0, false, false, false);
$obj_pdf->Ln(20);
    
$obj_pdf->SetFont('helvetica', 'B', 12);
$obj_pdf->Cell(0, 0, 'INFORMACIÓN DEL DEPORTISTA', 0, 1, 'C', 0, '', 0,  0, '', 0);
$obj_pdf->Ln(5);

$obj_pdf->SetFont('helvetica', 'B', 10);
$obj_pdf->Cell(40, 0, 'DNI', 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(60, 0, 'APELLIDOS', 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(0, 0, 'NOMBRES', 1, 1, 'L', 0, '', 0,  0, '', 0);

$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->Cell(40, 0, $row['dni'], 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(60, 0, $row['apellido_1'].' '.$row['apellido_2'], 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(0, 0, $row['nombres'], 1, 1, 'L', 0, '', 0,  0, '', 0);

$obj_pdf->SetFont('helvetica', 'B', 10);
$obj_pdf->Cell(60, 0, 'FECHA DE NACIMIENTO', 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(0, 0, 'DOMICILIO', 1, 1, 'L', 0, '', 0,  0, '', 0);

$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->Cell(60, 0, date("d/m/Y", strtotime($row['fecha_nacimiento'])), 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(0, 0, $row['direccion'], 1, 1, 'L', 0, '', 0,  0, '', 0);

$obj_pdf->SetFont('helvetica', 'B', 10);
$obj_pdf->Cell(60, 0, 'SEXO', 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(60, 0, 'FAMILIA NUMEROSA', 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(0, 0, 'AUTORIZACIÓN DE FOTO', 1, 1, 'L', 0, '', 0,  0, '', 0);

$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->Cell(60, 0, $row['sexo'], 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(60, 0, $row['familia'], 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(0, 0, $row['afoto'], 1, 1, 'L', 0, '', 0,  0, '', 0);

$obj_pdf->SetFont('helvetica', 'B', 10);
$obj_pdf->Cell(70, 0, 'TELÉFONO (TUTOR)', 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(0, 0, 'EMAIL (TUTOR)', 1, 1, 'L', 0, '', 0,  0, '', 0);

$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->Cell(70, 0, $row['telefono_movil'], 1, 0, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->Cell(0, 0, $row['email_principal'], 1, 1, 'L', 0, '', 0,  0, '', 0);

$obj_pdf->SetFont('helvetica', 'B', 10);
$obj_pdf->Cell(0, 0, 'DEPORTE', 1, 1, 'L', 0, '', 0,  0, '', 0);
$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->Cell(0, 0, $row['deporte'].' / '.$row['tipo'].': '.$row['valor'], 1, 1, 'L', 0, '', 0,  0, '', 0);


$obj_pdf->Ln(5);
if ($row['foto']){
    $obj_pdf->Image(base_url('assets/uploads/'.$row['foto']), '', '', 45, 60, '', '', 'T', false, 100, '', false, false, 0, false, false, false);
}
// Close and output PDF document
// This method has several options, check the source code documentation for more information.*/
$obj_pdf->Output('DEPORTISTA-'.$row['id_inscripcion'].'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


?>