<?php
include("../../Includes/config.php");

$testID = mysqli_real_escape_string($conn, $_GET['testID']);
$patientType = mysqli_real_escape_string($conn, $_GET['patientType']);


$queryTest = "SELECT * FROM test WHERE testID='$testID'";
$resultTest = mysqli_query($conn, $queryTest);

if (!$resultTest) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

$TestFee = 0;

if($row = mysqli_fetch_assoc($resultTest)) {
    $TestFee = $row['amount'];
}

echo "<div class=\"register-input-group\">";
echo "<label for=\"doctor_fee\">Test Fee:</label>";
echo "<input type=\"text\" name=\"doctor_fee\" id=\"doctor_fee\" value=\"$TestFee\" readonly>";
echo "</div>";
?>
