<?php
include 'db_connection.php';

header('Content-Type: application/json');

$sql = "SELECT id, name, age FROM patients";
$result = $conn->query($sql);

$patients = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
} else {
    echo json_encode(['error' => 'No patients found']);
    exit;
}

echo json_encode($patients);
$conn->close();
?>
