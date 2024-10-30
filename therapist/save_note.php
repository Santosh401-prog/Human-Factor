<?php
include 'db_connection.php';

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$groupName = $input['groupName'];
$note = $input['note'];

if (!$groupName || !$note) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO group_notes (group_name, note) VALUES (?, ?)");
$stmt->bind_param("ss", $groupName, $note);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save note']);
}
$stmt->close();
$conn->close();
?>
