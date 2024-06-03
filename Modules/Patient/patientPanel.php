<?php
    include("../../Includes\config.php");
    session_start();

    if(!isset($_SESSION["email"])) {
        header("location: ../Account\login.php");
    }

    $email = $_SESSION["email"];
    $password = $_SESSION["password"];

    $query = "SELECT * FROM patient WHERE email='$email'";

    $getquery = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($getquery)) {
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $image = $row['image'];
        $p_id = $row['patientID'];
        $phone = $row['phone'];
    }

    $name = $firstName . ' ' . $lastName;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

    <link rel="stylesheet" href="../../CSS/module.css">
    <link rel="icon" href="../../Images\Debidwar Diabetes & Diagnostic Center.png" type="images/x-icon">
    <title>Patient Panel</title>
</head>
<body>
    <div class="side-nav">
        <div class="side-nav-logo">
            <img src="../../Images\Debidwar Diabetes & Diagnostic Center.png" alt="">
        </div>

        <div class="side-nav-links">
            <ul>
                <li>
                    <a href="#dashboard">
                        <i class="fa-solid fa-border-all"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#appointment">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Appointment</span>
                    </a>
                </li>
                <li>
                    <a href="#prescription">
                        <i class="fa-solid fa-prescription"></i>
                        <span>Prescription</span>
                    </a>
                </li>
                <li>
                    <a href="#test">
                        <i class="fa-solid fa-flask-vial"></i>
                        <span>Tests</span>
                    </a>
                </li>
                <li>
                    <a href="#report">
                        <i class="fa-solid fa-file-word"></i>
                        <span>Report</span>
                    </a>
                </li>
                <li>
                    <a href="#settings">
                        <i class="fa-solid fa-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="profile-content">
            <div class="profile">
                <div class="profile-details">
                    <img src="../Uploaded/Patient/<?php echo $image?>" alt="">

                    <div class="name-job">
                        <div class="name"><?php echo $firstName?></div>
                        <div class="job">Patient</div>
                    </div>
                </div>
                <a href="../Account\logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
    </div>
    <nav>
        <span>
            <i class="fa-regular fa-calendar"></i>
            <?php echo date("d/m/Y")?>
        </span>
        <span>
            Patient Panel
        </span>
        <span>
            <a href="">
                <i class="fa-solid fa-user"></i>
                <p><?php echo $name?></p>
            </a>
        </span>
    </nav>

    <div class="content">
        <section id="dashboard" class="content-section active-section">
            <div class="dashboard-container">
                <div class="profile-card">
                    <div class="img-box">
                        <img src="../Uploaded/Patient/<?php echo $image?>" alt="">
                    </div>
                    <div class="text">
                        <span class="first">Hello!! </span> <span class="second"><?php echo $name?></span>
                        <h3>Welcome to Patient Panel</h3>
                    </div>
                </div>
            </div>
        </section>

        <section id="appointment" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>My Appointment Schedule</h1>
                    <a href="newAppointment.php?p_id=<?php echo $row['patientID']; ?>">New Appointment</a>
                </div>
                <div class="admin-table">
                    <div class="item-container">
                        <?php
                        $sql = "SELECT appointment.*, CONCAT(doctor.firstName, ' ', doctor.lastName) AS doctorName, payment.paymentID 
                        FROM appointment 
                        INNER JOIN doctor ON appointment.doctorID = doctor.doctorID 
                        LEFT JOIN payment ON appointment.appointmentID = payment.appointmentID 
                        WHERE appointment.patientID ='$p_id' 
                        AND appointment.appointmentType = 'Doctor'";                

                        $result = $conn->query($sql);

                        if($result->num_rows > 0) {
                            while($rows = $result->fetch_assoc()) {
                                echo "
                                <div class=\"appointment-item\">
                                    <strong>Appointment Day: </strong>" . $rows["appointmentDay"] . "<br>
                                    <strong>Time: </strong>" . $rows["appointmentTime"] . "<br>
                                    <strong>Doctor: </strong>" . $rows["doctorName"] . "<br>
                                    <strong>Status: </strong>" . $rows["status"] . "<br>
                                    <a href=\"AppReceipt.php?appointmentID={$rows['appointmentID']}&paymentID={$rows['paymentID']}\" class=\"btn btn-download\">Generate Receipt</a>
                                </div>
                                ";
                            } 
                        } else {
                            echo "No Appointment Found";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="prescription" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>My Prescriptions</h1>
                </div>
                <div class="admin-table">
                    <div class="item-container">
                    <?php
                        $sql = "SELECT appointment.*, 
                        CONCAT(doctor.firstName, ' ', doctor.lastName) AS doctorName, 
                        prescription.prescriptionID,
                        prescription.medicineList,
                        GROUP_CONCAT(test.testName SEPARATOR ', ') AS suggestedTests
                        FROM appointment 
                        INNER JOIN doctor ON appointment.doctorID = doctor.doctorID 
                        LEFT JOIN prescription ON appointment.appointmentID = prescription.appointmentID
                        LEFT JOIN test ON prescription.testID = test.testID
                        WHERE appointment.patientID ='$p_id' 
                        AND appointment.appointmentType = 'Doctor'
                        GROUP BY appointment.appointmentID,
                        appointment.appointmentDay,
                        appointment.appointmentTime,
                        appointment.doctorID,
                        appointment.status,
                        prescription.prescriptionID,
                        prescription.medicineList";              

                        $result = $conn->query($sql);

                        if($result) {
                            if($result->num_rows > 0) {
                                while($rows = $result->fetch_assoc()) {
                                    $prescriptionArray = json_decode($rows["medicineList"], true);
                                    $prescription = "";
                        
                                    if (!empty($prescriptionArray)) {
                                        foreach ($prescriptionArray as $item) {
                                            $prescription .= "{$item}<br>";
                                        }
                        
                                        echo "
                                        <div class=\"appointment-item\">
                                            <strong>Appointment Day: </strong>" . $rows["appointmentDay"] . "<br>
                                            <strong>Time: </strong>" . $rows["appointmentTime"] . "<br>
                                            <strong>Doctor: </strong>" . $rows["doctorName"] . "<br>
                                            <strong>Suggested Tests: </strong>" . ($rows["suggestedTests"] ?? "None") . "<br>
                                            <strong>Prescribed Medicines: <br></strong>{$prescription}<br>
                                            <a href=\"prescription.php?appointmentID={$rows['appointmentID']}&prescriptionID={$rows['prescriptionID']}\" class=\"btn btn-download\">Download Prescription</a>
                                        </div>
                                        ";
                                    }
                                } 
                            } else {
                                echo "No Prescription Found";
                            }
                        } else {
                            echo "Error executing query: " . $conn->error;
                        }
                        
                        
                    ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="test" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>My Test Schedule</h1>
                    <a href="newTest.php?p_id=<?php echo $row['patientID']; ?>">Schedule Test</a>
                </div>
                <div class="admin-table">
                    <div class="item-container">
                        <?php
                        $sql = "SELECT appointment.*, CONCAT(test.testName) AS testName, payment.paymentID 
                        FROM appointment 
                        INNER JOIN test ON appointment.testID = test.testID 
                        LEFT JOIN payment ON appointment.appointmentID = payment.appointmentID 
                        WHERE appointment.patientID ='$p_id' 
                        AND appointment.appointmentType = 'Test'";
                                
                        $result = $conn->query($sql);

                        if($result->num_rows > 0) {
                            while($rows = $result->fetch_assoc()) {
                                echo "
                                <div class=\"appointment-item\">
                                    <strong>Appointment Day: </strong>" . $rows["appointmentDay"] . "<br>
                                    <strong>Time: </strong>" . $rows["appointmentTime"] . "<br>
                                    <strong>Test Name: </strong>" . $rows["testName"] . "<br>
                                    <a href=\"TestReceipt.php?appointmentID={$rows['appointmentID']}&paymentID={$rows['paymentID']}\" class=\"btn btn-download\">Generate Receipt</a>
                                </div>
                                ";
                            } 
                        } else {
                            echo "No Appointment Found";
                        }
                        ?>
                </div>
            </div>
        </section>

        <section id="report" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>My Test Reports</h1>
                </div>
                <div class="admin-table">
                    <div class="item-container">
                    <?php
                        $sql = "SELECT appointment.*, CONCAT(test.testName) AS testName, report.reportID, report.description
                                FROM appointment 
                                INNER JOIN test ON appointment.testID = test.testID 
                                LEFT JOIN report ON appointment.appointmentID = report.appointmentID 
                                WHERE appointment.patientID ='$p_id' 
                                AND appointment.appointmentType = 'Test'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($rows = $result->fetch_assoc()) {
        $reportArray = json_decode($rows["description"], true);
        $description = "";

        // Check if report exists before processing
        if (!empty($reportArray)) {
            foreach ($reportArray as $item) {
                $description .= "{$item}<br>";
            }

            // Display report card only if report exists
            echo "
            <div class=\"appointment-item\">
                <strong>Appointment Day: </strong>{$rows["appointmentDay"]}<br>
                <strong>Time: </strong>{$rows["appointmentTime"]}<br>
                <strong>Test Name: </strong>{$rows["testName"]}<br>
                <strong>Report: <br> </strong>{$description}<br>
                <a href=\"report.php?appointmentID={$rows['appointmentID']}&reportID={$rows['reportID']}\" class=\"btn btn-download\">Download Report</a>
            </div>
            ";
        }
    }
} else {
    echo "No Report Found";
}

                    ?>
                </div>
            </div>
        </section>

        <section id="settings" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>Settings</h1>
                </div>
                <div class="admin-table update">
                    <h2>Update Information</h2>
                    <form action="settings.php?patientID=<?php echo $p_id; ?>" class="register" method="post" enctype="multipart/form-data">
                        <div class="register-input-row">
                            <div class="register-input-group">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" id="" placeholder="<?php echo $firstName ?>">
                            </div>
                            <div class="register-input-group">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" id="" placeholder="<?php echo $lastName ?>">
                            </div>
                        </div>
                        <div class="register-input-row">
                            <div class="register-input-group">
                                <label for="">Email</label>
                                <input type="email" name="email" id="" placeholder="<?php echo $email ?>">
                            </div>
                            <div class="register-input-group">
                                <label for="">Phone</label>
                                <input type="tel" name="phone" id="" placeholder="<?php echo $phone ?>">
                            </div>
                        </div>
                        <div class="register-input-row">
                            <div class="register-input-group">
                                <label for="">Old Password</label>
                                <input type="password" name="old_password" id="" placeholder="Password">
                            </div>
                            <div class="register-input-group">
                                <label for="">New Password</label>
                                <input type="password" name="new_password" id="" placeholder="New Password">
                            </div>
                        </div>
                        <div class="register-input-row-column">
                            <div class="register-input-group-column">
                                <label for="profile_picture">Upload a Picture</label>
                                <input type="file" name="profile_picture" id="profile_picture" accept=".jpg, .jpeg, .png, .gif, .bmp, .tiff, .tif" placeholder="Photo">
                            </div>
                        </div>
                        <button type="submit">Update Data</button>
                    </form>
                </div>
            </div>
        </section>
    </div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".side-nav-links a");
    const sections = document.querySelectorAll(".content-section");

    function showSection(sectionId) {
      sections.forEach((section) => {
        if (section.id === sectionId) {
          section.classList.add("active-section");
          section.classList.remove("inactive-section");
        } else {
          section.classList.remove("active-section");
          section.classList.add("inactive-section");
        }
      });

      sessionStorage.setItem("selectedSection", sectionId);
    }

    navLinks.forEach((link) => {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        const sectionId = link.getAttribute("href").substring(1);
        showSection(sectionId);
      });
    });

    const selectedSection = sessionStorage.getItem("selectedSection");
    if (selectedSection) {
      showSection(selectedSection);
    }
  });
</script>




</body>
</html>