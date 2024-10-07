<?php
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="group-27">
    <link rel ="stylesheet" href="Prof_Staff/style.css">
    <title>Staff Portal | CareWeb Service</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Staff Portal</h1>
        <a href="patient_database.php" class="btn">Patient Database</a>
        <a href="schedule_appointment.php" class="btn">Schedule Appointment</a>
        <br><br>
        <a href="logout.php" class="btn" style="background-color: #f44336;">Logout</a>
    </div>
</body>
</html>
