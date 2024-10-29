<?php
include 'db_connection.php';

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$groupName = $input['name'];
$groupType = $input['type'];
$patients = $input['patients'];

$stmt = $conn->prepare("INSERT INTO groups (name, type) VALUES (?, ?)");
$stmt->bind_param("ss", $groupName, $groupType);

if ($stmt->execute()) {
    $groupId = $stmt->insert_id;

    $stmt = $conn->prepare("INSERT INTO group_patients (group_id, patient_id) VALUES (?, ?)");
    foreach ($patients as $patientId) {
        $stmt->bind_param("ii", $groupId, $patientId);
        $stmt->execute();
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
