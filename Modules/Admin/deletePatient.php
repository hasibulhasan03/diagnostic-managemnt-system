<?php
    include("../../Includes\config.php");

    if (isset($_GET['patientID'])) {
        $patientID = $_GET['patientID'];

        $sql = "DELETE FROM patient WHERE patientID ='$patientID'"; 
        if ($conn->query($sql) === TRUE) {
            header("location: ../Admin/adminPanel.php");
        } else {
            echo "Error: Unable to delete patient.";
        }
    } else {
        echo "patient ID not provided.";
    }
?>
