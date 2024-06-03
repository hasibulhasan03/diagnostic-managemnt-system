<?php
    include("../../Includes\config.php");

    if (isset($_GET['testID'])) {
        $testID = $_GET['testID'];

        $sql = "DELETE FROM test WHERE testID ='$testID'"; 
        if ($conn->query($sql) === TRUE) {
            header("location: ../Admin/adminPanel.php");
        } else {
            echo "Error: Unable to delete test.";
        }
    } else {
        echo "test ID not provided.";
    }
?>
