<?php
require_once('../../tcpdf/tcpdf.php');
include("../../Includes/config.php");

function generatePDFReceipt($appointmentID, $reportID, $conn) {
    // Fetch appointment data
    $appointmentSql = "SELECT * FROM appointment WHERE appointmentID = $appointmentID";
    $appointmentResult = $conn->query($appointmentSql);
    if (!$appointmentResult) {
        die("Error executing appointment query: " . $conn->error);
    }
    $appointmentData = $appointmentResult->fetch_assoc();

    // Fetch report data
    $reportSql = "SELECT * FROM report WHERE reportID = $reportID";
    $reportResult = $conn->query($reportSql);
    if (!$reportResult) {
        die("Error executing report query: " . $conn->error);
    }
    $reportData = $reportResult->fetch_assoc();

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
    $pdf->SetTitle('Report Receipt');
    $pdf->SetSubject('Report Receipt');
    $pdf->SetKeywords('Report, Receipt, Hospital');

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
        
    // report details
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Report Details', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Appointment ID: ' . $appointmentData['appointmentID'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Patient Name: ' . $patientData['firstName'] . ' ' . $patientData['lastName'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Appointment Date: ' . $appointmentData['appointmentDay'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Appointment Time: ' . $appointmentData['appointmentTime'], 0, 1, 'L');
    $pdf->Ln(10);

    // Medicine details
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Test Report', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 13);

    // Fetch test name from the test table based on test ID
    $testID = $appointmentData['testID'];
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
    $pdf->MultiCell(0, 10, 'Test Name: ' . $testName, 0, 'L');
    $pdf->SetFont('helvetica', 'B', 12);
    
    $pdf->Cell(0, 10, 'Report: ', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);

    // Split the report description array into separate lines and output each line
    $reportDescription = json_decode($reportData['description'], true);
    foreach ($reportDescription as $descriptionLine) {
        $pdf->MultiCell(0, 10, $descriptionLine, 0, 'L');
    }
    

        // Output the PDF to the browser
        $pdf->Output("report_$appointmentID.pdf", 'I');

        // Terminate script execution
        exit();
    }

    if(isset($_GET['appointmentID']) && isset($_GET['reportID'])) {
        $appointmentID = $_GET['appointmentID'];
        $reportID = $_GET['reportID'];
        generatePDFReceipt($appointmentID, $reportID, $conn);
    } else {
        echo "Appointment ID and report ID are required parameters.";
    }
?>
