<?php
session_start();

// Check if the patient is logged in
if (!isset($_SESSION['patient_name'])) {
    echo json_encode(['error' => 'No patient logged in']);
    exit();
}

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

// Fetch journal entries for the logged-in patient
$patient_name = $_SESSION['patient_name'];

// Debug the session data to see if the patient_name is correct
var_dump($patient_name);

$stmt = $pdo->prepare("SELECT * FROM journal_entries WHERE patient_name = ? ORDER BY entry_date DESC");
$stmt->execute([$patient_name]);
$journal_entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debug the journal entries to see what is being fetched
var_dump($journal_entries);

// Send the result as a JSON response
if ($journal_entries) {
    echo json_encode($journal_entries);
} else {
    echo json_encode(['error' => 'No journal entries found']);
}
?>
