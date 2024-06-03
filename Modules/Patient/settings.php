<?php
include("../../Includes/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_GET['patientID'])) {
        $patientID = $_GET['patientID'];
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];

        $sql = "SELECT * FROM patient WHERE patientID = $patientID";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row['password'];

            if ($oldPassword == $storedPassword) {
                $updates = array();
                
                if (!empty($_POST['first_name'])) {
                    $updates[] = "firstName = '" . mysqli_real_escape_string($conn, $_POST['first_name']) . "'";
                }
                if (!empty($_POST['last_name'])) {
                    $updates[] = "lastName = '" . mysqli_real_escape_string($conn, $_POST['last_name']) . "'";
                }
                if (!empty($_POST['email'])) {
                    $updates[] = "email = '" . mysqli_real_escape_string($conn, $_POST['email']) . "'";
                }
                if (!empty($_POST['phone'])) {
                    $updates[] = "phone = '" . mysqli_real_escape_string($conn, $_POST['phone']) . "'";
                }
                if (!empty($_POST['new_password'])) {
                    $updates[] = "password = '" . mysqli_real_escape_string($conn, $_POST['new_password']) . "'";
                }

                if (!empty($_FILES['profile_picture']['name'])) {
                    $profilePicture = $_FILES['profile_picture']['name'];
                    $profilePictureTmp = $_FILES['profile_picture']['tmp_name'];
                    $profilePicturePath = "../Uploaded/Patient/" . $profilePicture;

                    if (move_uploaded_file($profilePictureTmp, $profilePicturePath)) {
                        $updates[] = "image = '" . mysqli_real_escape_string($conn, $profilePicture) . "'";
                    } else {
                        echo "Failed to upload profile picture.";
                    }
                }

                if (!empty($updates)) {
                    $updateSql = "UPDATE patient SET " . implode(', ', $updates) . " WHERE patientID = $patientID";

                    if (mysqli_query($conn, $updateSql)) {
                        echo "Data updated successfully.";
                        header("location: ../Patient/patientPanel.php");
                    } else {
                        echo "Error updating data: " . mysqli_error($conn);
                    }
                } else {
                    echo "No fields to update.";
                }
            } else {
                echo "Old password does not match.";
            }
        } else {
            echo "Admin not found.";
        }

        mysqli_close($conn);
    } else {
        echo "Admin ID not provided.";
    }
} else {
    echo "Invalid request method.";
}
?>
