<?php
    include("../../Includes\config.php");
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $testName = $_POST["testName"];
        $testAmount = $_POST["testAmount"];

            $query = "INSERT INTO test (testName, amount) VALUES ('$testName', '$testAmount')";

            if(mysqli_query($conn,$query) == TRUE) {
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

            <h1>Add Test</h1>

            <form action="" class = "register" method="post" enctype="multipart/form-data">      
                <div class="register-input-group-column">
                    <label for="profile_picture">Test Name</label>
                    <input type="text" name="testName" id="" placeholder="Example: Test" required>
                </div>

                <div class="register-input-group-column">
                    <label for="profile_picture">Test Amount</label>
                    <input type="text" name="testAmount" id="" placeholder="Example: Amount" required>
                </div>
                <button type="submit">Add Now</button>
            </form>
        </div>
    </section>
</body>
</html>