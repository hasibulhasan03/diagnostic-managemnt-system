<?php
include("../../Includes/config.php");

if(isset($_POST['prescribeButton'])) {
    $appointmentID = $_POST['appointmentID'];
    $testID = $_POST['testSuggestion'];
    $prescription = $_POST['prescription'];

    $prescriptionArray = explode(PHP_EOL, $prescription);
    $jsonPrescription = json_encode($prescriptionArray);

    $insertQuery = "INSERT INTO prescription (appointmentID, testID, medicineList) VALUES ('$appointmentID', '$testID', '$jsonPrescription')";

    if($conn->query($insertQuery) === TRUE) {
        echo "Prescription added successfully";
        header("Location: ../Doctor\doctorPanel.php");
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}
?>
