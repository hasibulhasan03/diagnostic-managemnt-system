<?php
include("../../Includes/config.php");

if(isset($_POST['prescribeButton'])) {
    $appointmentID = $_POST['appointmentID'];
    $prescription = $_POST['prescription'];

    $prescriptionArray = explode(PHP_EOL, $prescription);
    $jsonPrescription = json_encode($prescriptionArray);

    $insertQuery = "INSERT INTO report (appointmentID, description) VALUES ('$appointmentID',  '$jsonPrescription')";

    if($conn->query($insertQuery) === TRUE) {
        echo "Report added successfully";
        header("Location: ../Staff\staffPanel.php");
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}
?>
