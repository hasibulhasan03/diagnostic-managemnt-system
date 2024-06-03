<?php
    include("../../Includes\config.php");
    session_start();

    if(!isset($_SESSION["email"])) {
        header("location: ../Account\login.php");
    }

    $email = $_SESSION["email"];
    $password = $_SESSION["password"];

    $query = "SELECT * FROM admin WHERE email='$email'";

    $getquery = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($getquery)) {
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $image = $row['image'];
        $phone = $row['phone'];
        $adminID = $row['adminID'];
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
    <title>Admin Panel</title>
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
                    <a href="#admin">
                        <i class="fa-solid fa-user-shield"></i>
                        <span>Admin</span>
                    </a>
                </li>
                <li>
                    <a href="#doctor">
                        <i class="fa-solid fa-user-doctor"></i>
                        <span>Doctor</span>
                    </a>
                </li>
                <li>
                    <a href="#staff">
                        <i class="fa-solid fa-users"></i>
                        <span>Staff</span>
                    </a>
                </li>
                <li>
                    <a href="#patient">
                        <i class="fa-solid fa-hospital-user"></i>
                        <span>Patient</span>
                    </a>
                </li>
                <li>
                    <a href="#test">
                        <i class="fa-solid fa-flask-vial"></i>
                        <span>Tests</span>
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
                    <img src="../Uploaded/Admin/<?php echo $image?>" alt="">

                    <div class="name-job">
                        <div class="name"><?php echo $firstName?></div>
                        <div class="job">Admin</div>
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
            Admin Panel
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
                        <img src="../Uploaded/Admin/<?php echo $image?>" alt="">
                    </div>
                    <div class="text">
                        <span class="first">Hello!! </span> <span class="second"><?php echo $name?></span>
                        <h3>Welcome to Admin Panel</h3>
                    </div>
                </div>

                <div class="count-container">
                    <div class="count-card">
                        <h2>Total Admin</h2>
                        <div class="card-flex">
                            <i class="fa-solid fa-user-shield"></i>
                            <?php
                                $admin_count = "SELECT * FROM admin";
                                $get_admin_count = mysqli_query($conn, $admin_count);

                                if($admin_count_rows = mysqli_num_rows($get_admin_count))
                                {
                                    echo '<h1>  '.$admin_count_rows.'+</h1>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="count-card">
                        <h2>Total Doctor</h2>
                        <div class="card-flex">
                            <i class="fa-solid fa-user-doctor"></i>
                            <?php
                                $admin_count = "SELECT * FROM doctor";
                                $get_admin_count = mysqli_query($conn, $admin_count);

                                if($admin_count_rows = mysqli_num_rows($get_admin_count))
                                {
                                    echo '<h1>  '.$admin_count_rows.'+</h1>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="count-card">
                        <h2>Total Staff</h2>
                        <div class="card-flex">
                            <i class="fa-solid fa-users"></i>
                            <?php
                                $admin_count = "SELECT * FROM staff";
                                $get_admin_count = mysqli_query($conn, $admin_count);

                                if($admin_count_rows = mysqli_num_rows($get_admin_count))
                                {
                                    echo '<h1>  '.$admin_count_rows.'+</h1>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="count-card">
                        <h2>Total Patient</h2>
                        <div class="card-flex">
                            <i class="fa-solid fa-hospital-user"></i>
                            <?php
                                $admin_count = "SELECT * FROM patient";
                                $get_admin_count = mysqli_query($conn, $admin_count);

                                if($admin_count_rows = mysqli_num_rows($get_admin_count))
                                {
                                    echo '<h1>  '.$admin_count_rows.'+</h1>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="admin" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>Admin List</h1>
                    <a href="registerAdmin.php">Add Admin</a>
                </div>
                <div class="admin-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Of Birth</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <?php
                            $sql = "SELECT * FROM admin";
                            $result = $conn->query($sql);

                            while($rows = $result->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>" . $rows["adminID"] . "</td>
                                        <td>" . $rows["firstName"] . "</td>
                                        <td>" . $rows["lastName"] . "</td>
                                        <td>" . $rows["email"] . "</td>
                                        <td>" . $rows["phone"] . "</td>
                                        <td>" . $rows["dateOfBirth"] . "</td>
                                        <td><a href='deleteAdmin.php?adminID=".$rows["adminID"]."'>Delete</a></td>
                                    </tr>";
                            }
                        ?>

                    </table>
                </div>
            </div>
        </section>

        <section id="doctor" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>Doctor List</h1>
                    <a href="registerDoctor.php">Add Doctor</a>
                </div>
                <div class="admin-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Of Birth</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <?php
                            $sql = "SELECT * FROM doctor";
                            $result = $conn->query($sql);

                            while($rows = $result->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>" . $rows["doctorID"] . "</td>
                                        <td>" . $rows["firstName"] . "</td>
                                        <td>" . $rows["lastName"] . "</td>
                                        <td>" . $rows["email"] . "</td>
                                        <td>" . $rows["phone"] . "</td>
                                        <td>" . $rows["dateOfBirth"] . "</td>
                                        <td><a href='deleteDoctor.php?doctorID=".$rows["doctorID"]."'>Delete</a></td>
                                    </tr>";
                                
                            }
                        ?>
                    </table>
                </div>
            </div>
        </section>

        <section id="staff" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>Staff List</h1>
                    <a href="registerStaff.php">Add Staff</a>
                </div>
                <div class="admin-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Of Birth</th>
                                <th>Staff Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <?php
                            $sql = "SELECT * FROM staff";
                            $result = $conn->query($sql);

                            while($rows = $result->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>" . $rows["staffID"] . "</td>
                                        <td>" . $rows["firstName"] . "</td>
                                        <td>" . $rows["lastName"] . "</td>
                                        <td>" . $rows["email"] . "</td>
                                        <td>" . $rows["phone"] . "</td>
                                        <td>" . $rows["dateOfBirth"] . "</td>
                                        <td>" . $rows["staffType"] . "</td>
                                        <td><a href='deleteStaff.php?staffID=".$rows["staffID"]."'>Delete</a></td>
                                    </tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </section>

        <section id="patient" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>Patient List</h1>
                    <a href="registerPatient.php">Add Patient</a>
                </div>
                <div class="admin-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date Of Birth</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <?php
                            $sql = "SELECT * FROM patient";
                            $result = $conn->query($sql);

                            while($rows = $result->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>" . $rows["patientID"] . "</td>
                                        <td>" . $rows["firstName"] . "</td>
                                        <td>" . $rows["lastName"] . "</td>
                                        <td>" . $rows["email"] . "</td>
                                        <td>" . $rows["phone"] . "</td>
                                        <td>" . $rows["dateOfBirth"] . "</td>
                                        <td><a href='deletePatient.php?patientID=".$rows["patientID"]."'>Delete</a></td>
                                    </tr>";
                            }
                        ?>

                    </table>
                </div>
            </div>
        </section>

        <section id="test" class="content-section inactive-section">
            <div class="admin-container">
                <div class="admin-top">
                    <h1>Test List</h1>
                    <a href="addTest.php">Add Test</a>
                </div>
                <div class="admin-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Test Name</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <?php
                            $sql = "SELECT * FROM test";
                            $result = $conn->query($sql);

                            while($rows = $result->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>" . $rows["testID"] . "</td>
                                        <td>" . $rows["testName"] . "</td>
                                        <td>" . $rows["amount"] . "</td>
                                        <td><a href='deleteTest.php?testID=".$rows["testID"]."'>Delete</a></td>
                                    </tr>";
                            }
                        ?>

                    </table>
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
                    <form action="settings.php?adminID=<?php echo $adminID; ?>" class="register" method="post" enctype="multipart/form-data">
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