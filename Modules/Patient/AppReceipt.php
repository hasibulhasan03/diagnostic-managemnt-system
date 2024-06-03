<?php
require_once('../../tcpdf/tcpdf.php');
include("../../Includes/config.php");

function generatePDFReceipt($appointmentID, $paymentID, $conn) {

    $appointmentSql = "SELECT * FROM appointment WHERE appointmentID = $appointmentID";
    $appointmentResult = $conn->query($appointmentSql);
    $appointmentData = $appointmentResult->fetch_assoc();

    $paymentSql = "SELECT * FROM payment WHERE paymentID = $paymentID";
    $paymentResult = $conn->query($paymentSql);
    $paymentData = $paymentResult->fetch_assoc();


    $patientID = $appointmentData['patientID'];
    $patientSql = "SELECT * FROM patient WHERE patientID = $patientID";
    $patientResult = $conn->query($patientSql);
    $patientData = $patientResult->fetch_assoc();


    $doctorID = $appointmentData['doctorID'];
    $doctorSql = "SELECT * FROM doctor WHERE doctorID = $doctorID";
    $doctorResult = $conn->query($doctorSql);
    $doctorData = $doctorResult->fetch_assoc();


    $pdf = new TCPDF('L', 'mm', 'A5', true, 'UTF-8', false);


    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Hospital Name');
    $pdf->SetTitle('Appointment Receipt');
    $pdf->SetSubject('Appointment Receipt');
    $pdf->SetKeywords('Appointment, Receipt, Hospital');


    $pdf->AddPage();


    $pdf->SetFont('helvetica', '', 12);


    $hospitalName = 'DEBIDWAR DIABETES & DIAGNOSTIC CENTER';
    $hospitalLocation = 'Location: Debidwar, Cumilla';
    $hospitalPhone = 'Phone: 01643183705';


    $pdf->Cell(100, 10, $hospitalName, 0, 0, 'L');
    $pdf->Cell(0, 10, $hospitalLocation, 0, 1, 'R');
    $pdf->Cell(100, 10, '', 0, 0, 'L');
    $pdf->Cell(0, 10, $hospitalPhone, 0, 1, 'R');
    $pdf->Ln(10);


    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(100, 10, 'Appointment Details', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(100, 10, 'Appointment ID: ' . $appointmentData['appointmentID'], 0, 1, 'L');
    $pdf->Cell(100, 10, 'Doctor Name: ' . $doctorData['firstName'] . ' ' . $doctorData['lastName'], 0, 1, 'L');
    $pdf->Cell(100, 10, 'Patient Name: ' . $patientData['firstName'] . ' ' . $patientData['lastName'], 0, 1, 'L');
    $pdf->Cell(100, 10, 'Appointment Date: ' . $appointmentData['appointmentDay'], 0, 1, 'L');
    $pdf->Cell(100, 10, 'Appointment Time: ' . $appointmentData['appointmentTime'], 0, 1, 'L');


    $pdf->SetXY(120, 40);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(100, 10, 'Payment Details', 0, 1, 'L');
    

    $pdf->SetX(120);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(100, 10, 'Payment Type: ' . $paymentData['paymentType'], 0, 1, 'L');
    $pdf->SetX(120);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(100, 10, 'Amount: ' . $paymentData['amount'], 0, 1, 'L');
    

 
    $pdf->SetXY(100, 110);
    $pdf->Cell(100, 10, 'PAID', 0, 1, 'C');


    $pdf->Output("receipt_$appointmentID.pdf", 'I');


    exit();
}

if(isset($_GET['appointmentID']) && isset($_GET['paymentID'])) {
    $appointmentID = $_GET['appointmentID'];
    $paymentID = $_GET['paymentID'];
    generatePDFReceipt($appointmentID, $paymentID, $conn);
} else {
    echo "Appointment ID and Payment ID are required parameters.";
}
?>
