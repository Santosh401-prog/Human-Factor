<?php
include 'db_connection.php';

header('Content-Type: application/json');

$sql = "SELECT id, name, age FROM patients";
$result = $conn->query($sql);

$patients = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

echo json_encode($patients);
$conn->close();
?>
