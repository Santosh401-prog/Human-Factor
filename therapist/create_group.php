<?php
// create_group.php
header('Content-Type: application/json');
include 'db_connection.php'; // include your database connection file

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name']) && isset($data['type']) && isset($data['patients'])) {
    $groupName = $data['name'];
    $groupType = $data['type'];
    $patients = $data['patients'];

    // Convert the patients array to a string (comma-separated)
    $patientsString = implode(',', $patients);

    // Insert group into the database
    $sql = "INSERT INTO groups (name, type, patients) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $groupName, $groupType, $patientsString);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create group.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}

$conn->close();
?>
