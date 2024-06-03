<?php
include("../../Includes/config.php");
session_start();

$p_id = $_GET['p_id'];

$getInfo = "SELECT * FROM patient WHERE patientID='$p_id'";
$getquery = mysqli_query($conn, $getInfo);

if($row = mysqli_fetch_assoc($getquery)) {
    $firstName = $row['firstName'];
    $lastName = $row['lastName'];
    $email = $row['email'];
    $phone = $row['phone'];
    $dateOfBirth = $row['dateOfBirth'];
}

$name = $firstName . ' ' . $lastName;

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctorId = mysqli_real_escape_string($conn, $_POST['doctor']);
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $patientType = mysqli_real_escape_string($conn, $_POST['patient_type']);
    $doctorFee = mysqli_real_escape_string($conn, $_POST['doctor_fee']);
 

    if(!empty($doctorId) && !empty($day) && !empty($time) && !empty($patientType) && !empty($doctorFee)) {

        $queryAppointment = "INSERT INTO appointment (patientID, appointmentType, testID, appointmentDay, appointmentTime, patientType, status) VALUES ('$p_id', 'Test', '$doctorId', '$day', '$time', '$patientType', 'Confirmed')";

        if (mysqli_query($conn, $queryAppointment)) {
            $appointmentID = mysqli_insert_id($conn);


            $queryPayment = "INSERT INTO payment (appointmentID, paymentType, amount) VALUES ('$appointmentID', 'Cash', '$doctorFee')";

            if (mysqli_query($conn, $queryPayment)) {
                header("location: ../Patient/patientPanel.php");
                exit();
            } else {
                echo "Error inserting into Payment table: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting into Appointment table: " . mysqli_error($conn);
        }
    } else {
        echo "All fields are required.";
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
    <title>New Appointment</title>
</head>
<body>
<section class="login">
    <div class="login-container register-container">
        <img src="../../Images\Debidwar Diabetes & Diagnostic Center.png" alt="">
        <h1>New Appointment</h1>
        <form action="" class="register" method="post" enctype="multipart/form-data">
            <div class="register-input-row">
                <div class="register-input-group">
                    <input type="text" name="first_name" id="" placeholder="<?php echo $name?>" readonly>
                </div>
                <div class="register-input-group">
                    <input type="tel" name="phone" id="" placeholder="<?php echo $phone ?>" readonly>
                </div>
            </div>
            <div class="register-input-row">
                <div class="register-input-group">
                    <label for="patient_type">Patient Type</label>
                    <select name="patient_type" id="patient_type">
                        <option value="" disabled selected>Select From Here</option>
                        <option value="New">New Patient</option>
                        <option value="Old">Old Patient</option>
                    </select>
                </div>
                <div class="register-input-group">
                    <label for="doctor">Select Test</label>
                    <select name="doctor" id="doctor">
                        <option value="" disabled selected>Select From Here</option>
                        <?php
                            $queryTestList = "SELECT testID, testName FROM test";
                            $resultTestList = mysqli_query($conn, $queryTestList);
                            while ($row = mysqli_fetch_assoc($resultTestList)) {
                                echo "<option value='{$row['testID']}'>{$row['testName']}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="register-input-row">
                <div class="register-input-group">
                    <label for="day">Select Day</label>
                    <select name="day" id="day">
                        <option value="" disabled selected>Select Day</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                    </select>
                </div>
                <div class="register-input-group">
                    <label for="time">Select Time</label>
                    <select name="time" id="time">
                        <option value="" disabled selected>Select Time</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                    </select>
                </div>
            </div>
            <div class="register-input-row-column">
                <div id="schedule"></div>  
            </div>
            <button type="submit" id="payNowButton">Pay Now</button>
        </form>
    </div>
</section>

<script>
    function checkSelection() {
        var patientType = document.getElementById("patient_type").value;
        var doctor = document.getElementById("doctor").value;
        if (patientType !== "" && doctor !== "") {
            document.getElementById("payNowButton").style.display = "block";
        } else {
            document.getElementById("payNowButton").style.display = "none";
        }
    }

    document.getElementById("patient_type").addEventListener("change", checkSelection);
    document.getElementById("doctor").addEventListener("change", checkSelection);

    document.getElementById("doctor").addEventListener("change", function() {
        var testID = this.value;
        var patientType = document.getElementById("patient_type").value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("schedule").innerHTML = xhr.responseText;
            }
        };
        xhr.open("GET", "get_amount.php?testID=" + testID + "&patientType=" + patientType, true);
        xhr.send();
    });
</script>

</body>
</html>
