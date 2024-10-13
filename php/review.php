<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Change this if your MySQL username is different
$password = "";  // Change if you have a password
$dbname = "therapist_overview";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patient data
$sql = "SELECT patient_id, last_consultation, visits, assigned_therapist, status FROM patient_records"; // Update the table name and fields
$result = $conn->query($sql);

$patients = [];

if ($result->num_rows > 0) {
    // Fetch data as an associative array and push it to the $patients array
    while($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($patients);
?>
