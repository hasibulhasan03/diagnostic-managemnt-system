<?php
    include("../../Includes\config.php");

    if (isset($_GET['staffID'])) {
        $staffID = $_GET['staffID'];

        $sql = "DELETE FROM staff WHERE staffID ='$staffID'"; 
        if ($conn->query($sql) === TRUE) {
            header("location: ../Admin/adminPanel.php");
        } else {
            echo "Error: Unable to delete staff.";
        }
    } else {
        echo "staff ID not provided.";
    }
?>
