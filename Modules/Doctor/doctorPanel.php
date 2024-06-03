<?php
    include("../../Includes\config.php");
    session_start();

    if(!isset($_SESSION["email"])) {
        header("location: ../Account\login.php");
    }

    $email = $_SESSION["email"];
    $password = $_SESSION["password"];

    $query = "SELECT * FROM doctor WHERE email='$email'";

    $getquery = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($getquery)) {
        $doctorID = $row['doctorID'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $image = $row['image'];
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
    <title>Doctor Panel</title>
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
                    <a href="#patients">
                        <i class="fa-solid fa-users"></i>
                        <span>Patients</span>
                    </a>
                </li>
                <li>
                    <a href="#prescribe">
                        <i class="fa-solid fa-hospital-user"></i>
                        <span>Prescribe</span>
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
                    <img src="../Uploaded/Doctor/<?php echo $image?>" alt="">

                    <div class="name-job">
                        <div class="name"><?php echo $firstName?></div>
                        <div class="job">Doctor</div>
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
            Doctor Panel
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
                        <img src="../Uploaded/Doctor/<?php echo $image?>" alt="">
                    </div>
                    <div class="text">
                        <span class="first">Hello!! </span> <span class="second"><?php echo $name?></span>
                        <h3>Welcome to Doctor Panel</h3>
                    </div>
                </div>
            </div>
        </section>

        <section id="patients" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>My Patients</h1>
                </div>
                <div class="admin-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Patient Name</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Patient Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <?php
                            $sql = "SELECT appointment.*, CONCAT(patient.firstName, ' ', patient.lastName) AS patientName 
                            FROM appointment 
                            INNER JOIN patient ON appointment.patientID = patient.patientID 
                            WHERE appointment.doctorID='$doctorID'";

                            $result = $conn->query($sql);

                            while($rows = $result->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>" . $rows["appointmentID"] . "</td>
                                        <td>" . $rows["patientName"] . "</td>
                                        <td>" . $rows["appointmentDay"] . "</td>
                                        <td>" . $rows["appointmentTime"] . "</td>
                                        <td>" . $rows["patientType"] . "</td>
                                        <td>" . $rows["status"] . "</td>
                                    </tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </section>

        <section id="prescribe" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>Prescription Management</h1>
                </div>
                <div class="admin-table">
                    <div class="search-bar">
                        <form method="post" action="">
                            <label for="searchAppointment">Search Appointment:</label>
                            <div class="search-input">
                                <input type="text" id="searchAppointment" name="searchAppointment" placeholder="Enter Appointment ID">
                                <button type="submit" name="searchButton">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="prescription-form">
                        <?php if(isset($_POST['searchButton'])): ?>
                            <?php
                            $appointmentID = $_POST['searchAppointment'];
                            $query = "SELECT appointment.*, patient.firstName, patient.lastName, patient.phone, patient.dateOfBirth FROM appointment INNER JOIN patient ON appointment.patientID = patient.patientID WHERE appointment.appointmentID='$appointmentID' AND appointment.doctorID='$doctorID'";

                            $result = $conn->query($query);

                            if($result->num_rows > 0):
                                $row = $result->fetch_assoc();
                                $patientName = $row['firstName'] . ' ' . $row['lastName'];
                                $patientPhone = $row['phone'];
                                $patientDateOfBirth = $row['dateOfBirth'];
                            ?>
                                <div class="patient-info">
                                    <p><strong>Patient Name:</strong> <?php echo $patientName ?></p>
                                    <p><strong>Phone:</strong> <?php echo $patientPhone ?></p>
                                    <p><strong>Date of Birth:</strong> <?php echo $patientDateOfBirth ?></p>
                                </div>
                                <form method="post" action="prescribe.php" class="prescription-form">
                                    <input type="hidden" name="appointmentID" value="<?php echo $appointmentID ?>">
                                    <div class="form-group">
                                        <label for="testSuggestion">Suggest Test:</label>
                                        <select name="testSuggestion" id="testSuggestion">
                                            <option value="" selected disabled>Select Test (Optional)</option>
                                            <?php
                                            $testQuery = "SELECT testID, testName FROM test";
                                            $testResult = $conn->query($testQuery);
                                            while ($testRow = $testResult->fetch_assoc()) {
                                                echo "<option value='" . $testRow['testID'] . "'>" . $testRow['testName'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="prescription">Prescription:</label>
                                        <textarea name="prescription" id="prescription" placeholder="Enter prescription"></textarea>
                                    </div>
                                    <button type="submit" name="prescribeButton">Prescribe</button>
                                </form>
                            <?php else: ?>
                                <p>No appointment found with ID: <?php echo $appointmentID ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
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
                    <form action="settings.php?doctorID=<?php echo $doctorID; ?>" class="register" method="post" enctype="multipart/form-data">
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