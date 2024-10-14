<?php
// Database connection
$host = 'localhost';
$dbname = 'care_system';
$username = 'root';
$password = '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Fetch therapists
$stmtTherapists = $pdo->prepare("SELECT id, username FROM users WHERE role = 'therapist'");
$stmtTherapists->execute();
$therapists = $stmtTherapists->fetchAll(PDO::FETCH_ASSOC);

// Fetch patients
$stmtPatients = $pdo->prepare("SELECT id, username FROM users WHERE role = 'patient'");
$stmtPatients->execute();
$patients = $stmtPatients->fetchAll(PDO::FETCH_ASSOC);

// Return as JSON
header('Content-Type: application/json');  // Ensure JSON header is set
if ($therapists && $patients) {
    echo json_encode(['therapists' => $therapists, 'patients' => $patients]);
} else {
    echo json_encode(['error' => 'No therapists or patients found']);
}
?>
