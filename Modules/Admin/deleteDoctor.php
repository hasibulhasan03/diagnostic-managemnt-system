<?php
    include("../../Includes\config.php");

    if (isset($_GET['doctorID'])) {
        $doctorID = $_GET['doctorID'];

        $sql = "DELETE FROM doctor WHERE doctorID ='$doctorID'"; 
        if ($conn->query($sql) === TRUE) {
            header("location: ../Admin/adminPanel.php");
        } else {
            echo "Error: Unable to delete doctor.";
        }
    } else {
        echo "doctor ID not provided.";
    }
?>
