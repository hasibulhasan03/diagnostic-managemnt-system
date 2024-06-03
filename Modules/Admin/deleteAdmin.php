<?php
    include("../../Includes\config.php");

    if (isset($_GET['adminID'])) {
        $adminID = $_GET['adminID'];

        $sql = "DELETE FROM admin WHERE adminID ='$adminID'"; 
        if ($conn->query($sql) === TRUE) {
            header("location: ../Admin/adminPanel.php");
        } else {
            echo "Error: Unable to delete admin.";
        }
    } else {
        echo "Admin ID not provided.";
    }
?>
