<?php
include 'db_connection.php'; // Include your database connection file

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$groupName = $input['name'];
$groupType = $input['type'];
$patients = $input['patients'];

if (!$groupName || !$groupType || empty($patients)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Insert group into the database
$stmt = $conn->prepare("INSERT INTO groups (name, type) VALUES (?, ?)");
$stmt->bind_param("ss", $groupName, $groupType);
if ($stmt->execute()) {
    $groupId = $stmt->insert_id;
    $stmt->close();

    // Insert patients into the group
    $stmt = $conn->prepare("INSERT INTO group_patients (group_id, patient_id) VALUES (?, ?)");
    foreach ($patients as $patientId) {
        $stmt->bind_param("ii", $groupId, $patientId);
        $stmt->execute();
    }
    $stmt->close();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create group']);
}
$conn->close();
?>
