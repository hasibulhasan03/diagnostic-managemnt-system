<?php
include("../../Includes/config.php");

$doctorID = mysqli_real_escape_string($conn, $_GET['doctorID']);
$patientType = mysqli_real_escape_string($conn, $_GET['patientType']);

$query = "SELECT * FROM schedule WHERE doctorID = '$doctorID'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

echo "<div class=\"register-input-group\">";
echo "<label for=\"day\">Select Day:</label>";
echo "<select name=\"day\" id=\"day\">";
$availableDays = [];
while ($row = mysqli_fetch_assoc($result)) {
    $days = explode(", ", $row['availableDay']);
    $availableDays = array_merge($availableDays, $days);
}
$availableDays = array_unique($availableDays);
foreach ($availableDays as $day) {
    echo "<option value=\"$day\">$day</option>";
}
echo "</select>";
echo "</div>";

mysqli_data_seek($result, 0);

echo "<div class=\"register-input-group\">";
echo "<label for=\"time\">Select Time Slot:</label>";
echo "<select name=\"time\" id=\"time\">";
while ($row = mysqli_fetch_assoc($result)) {
    $startTime = strtotime($row['startTime']);
    $endTime = strtotime($row['endTime']);
    while ($startTime < $endTime) {
        echo "<option value=\"" . date("H:i", $startTime) . "\">" . date("H:i", $startTime) . " - " . date("H:i", $startTime + 3600) . "</option>";
        $startTime += 3600;
    }
}
echo "</select>";
echo "</div>";

$queryDoctor = "SELECT * FROM doctor WHERE doctorID='$doctorID'";
$resultDoctor = mysqli_query($conn, $queryDoctor);

if (!$resultDoctor) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

$doctorFee = 0;

if($row = mysqli_fetch_assoc($resultDoctor)) {
    $newFee = $row['newFee'];
    $oldFee = $row['oldFee'];
}

if ($patientType == "New") {
    $doctorFee = $newFee;
} elseif ($patientType == "Old") {
    $doctorFee = $oldFee;
} else {
    $doctorFee = "Select Patient Type";
}

echo "<div class=\"register-input-group\">";
echo "<label for=\"doctor_fee\">Doctor's Fee:</label>";
echo "<input type=\"text\" name=\"doctor_fee\" id=\"doctor_fee\" value=\"$doctorFee\" readonly>";
echo "</div>";
?>
