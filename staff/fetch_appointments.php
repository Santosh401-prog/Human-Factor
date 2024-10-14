<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = 'localhost';
$dbname = 'care_system'; // Your database name
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Fetch all scheduled appointments
$sql = "SELECT a.id, p.name AS patient_name, t.name AS therapist_name, a.appointment_date, a.appointment_time
        FROM appointments a
        JOIN patients p ON a.patient_id = p.id
        LEFT JOIN therapists t ON a.therapist_id = t.id
        ORDER BY a.appointment_date, a.appointment_time";

$stmt = $pdo->query($sql);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the appointments as JSON
header('Content-Type: application/json');
echo json_encode($appointments);
?>
