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

$stmt = $pdo->prepare("SELECT entry_date, mood, sleep_hours, eating_habit, exercise_minutes, journal_text, created_at 
                       FROM journal_entries WHERE patient_name = ? ORDER BY entry_date DESC");
$stmt->execute([$patient_name]);
$journal_entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send the result as a JSON response
if ($journal_entries) {
    echo json_encode($journal_entries);
} else {
    echo json_encode(['error' => 'No journal entries found']);
}
