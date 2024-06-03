<?php
    include("../../Includes\config.php");
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $dateOfBirth = date('Y-m-d',strtotime($_POST["date_of_birth"]));
        $gender = $_POST["gender"];
        $image = $_FILES['profile_picture']['name'];
        $tempIMG = $_FILES['profile_picture']['tmp_name'];
        $uploadIMG = '../Uploaded/Admin/'.$image;

            $query = "INSERT INTO admin (firstName, lastName, email, phone, dateOfBirth, gender, image) VALUES ('$firstName', '$lastName', '$email', '$phone', '$dateOfBirth', '$gender', '$image')";

            if(mysqli_query($conn,$query) == TRUE) {
                move_uploaded_file($tempIMG,$uploadIMG);
                header("location: ../Admin/adminPanel.php");
            } else {
                echo "Data Not Inserted";
            } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

    <link rel="stylesheet" href="../../CSS/module.css">
    <link rel="icon" href="../../Images\Debidwar Diabetes & Diagnostic Center.png" type="images/x-icon">
    <title>Admin Panel</title>
</head>
<body>
<section class="login">
        <div class="login-container register-container">
            <img src="../../Images\Debidwar Diabetes & Diagnostic Center.png" alt="">

            <h1>Admin Registration</h1>

            <form action="" class = "register" method="post" enctype="multipart/form-data">
                <div class="register-input-row">
                    <div class="register-input-group">
                        <input type="text" name="first_name" id="" placeholder="First Name" required>
                    </div>
                    <div class="register-input-group">
                        <input type="text" name="last_name" id="" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="register-input-row">
                    <div class="register-input-group">
                        <input type="email" name="email" id="" placeholder="Email" required>
                    </div>
                    <div class="register-input-group">
                        <input type="tel" name="phone" id="" placeholder="Phone" required>
                    </div>
                </div>
                <div class="register-input-row">
                    <div class="register-input-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="" placeholder="Date Of Birth" required>
                    </div>
                    <div class="register-input-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                </div>
                
                <div class="register-input-group-column">
                    <label for="profile_picture">Upload a Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept=".jpg, .jpeg, .png, .gif, .bmp, .tiff, .tif" placeholder="Photo" required>
                </div>
                <button type="submit">Register Admin</button>
            </form>
        </div>
    </section>
</body>
</html>