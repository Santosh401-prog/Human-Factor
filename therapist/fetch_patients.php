<?php
// fetch-patients.php
include 'db_connection.php'; // Include the database connection

header('Content-Type: application/json');

// Fetch patients from the patients table
$sql = "SELECT id, name FROM patients";
$result = $conn->query($sql);

$patients = [];
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

echo json_encode($patients);
$conn->close();
?>
