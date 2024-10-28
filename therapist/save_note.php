<?php
include 'db_connection.php'; // Include your database connection file

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$patientId = $input['patientId'];
$note = $input['note'];

if (!$patientId || !$note) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Insert note into the database
$stmt = $conn->prepare("INSERT INTO patient_notes (patient_id, note) VALUES (?, ?)");
$stmt->bind_param("is", $patientId, $note);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save note']);
}
$stmt->close();
$conn->close();
?>
