<?php
// Database connection
$host = 'localhost';
$dbname = 'care_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Determine whether to fetch therapists or patients
$fetch = isset($_GET['fetch']) ? $_GET['fetch'] : '';

if ($fetch == 'therapists') {
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE role = 'therapist'");
} elseif ($fetch == 'patients') {
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE role = 'patient'");
} else {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([$fetch => $data]);
?>
