<?php
// Connect to database
$conn = new mysqli('localhost', 'username', 'password', 'staff_portal');

// Check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patients
$sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS name, age FROM patients";
$result = $conn->query($sql);

$patients = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($patients);

$conn->close();
?>
