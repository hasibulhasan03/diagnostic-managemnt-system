<?php
require_once('../../tcpdf/tcpdf.php');
include("../../Includes/config.php");

function generatePDFReceipt($appointmentID, $prescriptionID, $conn) {
    // Fetch appointment data
    $appointmentSql = "SELECT * FROM appointment WHERE appointmentID = $appointmentID";
    $appointmentResult = $conn->query($appointmentSql);
    if (!$appointmentResult) {
        die("Error executing appointment query: " . $conn->error);
    }
    $appointmentData = $appointmentResult->fetch_assoc();
 
    // Fetch prescription data
    $prescriptionSql = "SELECT * FROM prescription WHERE prescriptionID = $prescriptionID";
    $prescriptionResult = $conn->query($prescriptionSql);
    if (!$prescriptionResult) {
        die("Error executing prescription query: " . $conn->error);
    }
    $prescriptionData = $prescriptionResult->fetch_assoc();

    // Fetch patient data
    $patientID = $appointmentData['patientID'];
    $patientSql = "SELECT * FROM patient WHERE patientID = $patientID";
    $patientResult = $conn->query($patientSql);
    if (!$patientResult) {
        die("Error executing patient query: " . $conn->error);
    }
    $patientData = $patientResult->fetch_assoc();

    // Create a new TCPDF instance
    $pdf = new TCPDF('H', 'mm', 'A5', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Hospital Name');
    $pdf->SetTitle('Prescription Receipt');
    $pdf->SetSubject('Prescription Receipt');
    $pdf->SetKeywords('Prescription, Receipt, Hospital');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'DEBIDWAR DIABETES & DIAGNOSTIC CENTER', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Location: Debidwar, Cumilla', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Phone: 01643183705', 0, 1, 'C');
    $pdf->Ln(10);
        
    // Prescription details
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Prescription Details', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Appointment ID: ' . $appointmentData['appointmentID'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Patient Name: ' . $patientData['firstName'] . ' ' . $patientData['lastName'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Appointment Date: ' . $appointmentData['appointmentDay'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Appointment Time: ' . $appointmentData['appointmentTime'], 0, 1, 'L');
    $pdf->Ln(10);

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Prescription: ', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);

    // Split the report description array into separate lines and output each line
    $prescriptionDescription = json_decode($prescriptionData['medicineList'], true);
    foreach ($prescriptionDescription as $prescriptionLine) {
        $pdf->MultiCell(0, 10, $prescriptionLine, 0, 'L');
    }

    // Fetch test name from the test table based on test ID
    $testID = $prescriptionData['testID'];
    if ($testID) {
        $testSql = "SELECT testName FROM test WHERE testID = $testID";
        $testResult = $conn->query($testSql);
        if ($testResult && $testResult->num_rows > 0) {
            $testData = $testResult->fetch_assoc();
            $testName = $testData['testName'];
        } else {
            $testName = 'N/A'; // Set test name to N/A if no test found
        }
    } else {
        $testName = 'N/A'; // Set test name to N/A if test ID is empty
    }
    
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->MultiCell(0, 10, 'Suggested Test: ' . $testName, 0, 'L');
        

        // Output the PDF to the browser
        $pdf->Output("prescription_$appointmentID.pdf", 'I');

        // Terminate script execution
        exit();
    }

    if(isset($_GET['appointmentID']) && isset($_GET['prescriptionID'])) {
        $appointmentID = $_GET['appointmentID'];
        $prescriptionID = $_GET['prescriptionID'];
        generatePDFReceipt($appointmentID, $prescriptionID, $conn);
    } else {
        echo "Appointment ID and prescription ID are required parameters.";
    }
?>
