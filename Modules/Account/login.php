<?php
    include("../../Includes\config.php");
    session_start();

    $message = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $admin = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
        $patient = "SELECT * FROM patient WHERE email='$email' AND password='$password'";
        $doctor = "SELECT * FROM doctor WHERE email='$email' AND password='$password'";
        $staff = "SELECT * FROM staff WHERE email='$email' AND password='$password'";


        $resultAdmin = mysqli_query($conn, $admin);
        $resultPatient = mysqli_query($conn, $patient);
        $resultDoctor = mysqli_query($conn, $doctor);
        $resultStaff = mysqli_query($conn, $staff);

        if($row = mysqli_fetch_assoc($resultAdmin)) {
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            header("Location: ../Admin\adminPanel.php");
            exit();
        }
        elseif($row = mysqli_fetch_assoc($resultPatient)) {
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            header("Location: ../Patient\patientPanel.php");
            exit();
        } 
        elseif($row = mysqli_fetch_assoc($resultDoctor)) {
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            header("Location: ../Doctor\doctorPanel.php");
            exit();
        } 
        elseif($row = mysqli_fetch_assoc($resultStaff)) {
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            header("Location: ../Staff\staffPanel.php");
            exit();
        } 
        else {
            $message = "Invalid Email or Password";
        }

        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/style.css">
    <link rel="icon" href="../../Images\Debidwar Diabetes & Diagnostic Center.png" type="images/x-icon">
    
    <title>Debidwar Diabetes & Diagnostic Center</title>
</head>
<body>
    <section class="login">
        <div class="login-container">
            <img src="../../Images\Debidwar Diabetes & Diagnostic Center.png" alt="">

            <h1>Login Here</h1>

            <div class="error-message">
                <?php echo $message ?>
            </div>

            <form action="" method="post">
                <input type="email" name="email" id="" placeholder="Email" required>

                <input type="password" name="password" id="" placeholder="Password" required>

                <button type="submit">Login</button>
            </form>

            <div class="member">
                Not a Member? <a href="register.php">Register Now</a>
            </div>
        </div>
    </section>
</body>
</html>