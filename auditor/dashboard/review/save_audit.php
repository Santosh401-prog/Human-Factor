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
    die("Could not connect to the database: " . $e->getMessage());
}

// Get the form data
$therapist_id = $_POST['therapist'];
$patient_id = $_POST['patient'];
$case_type = $_POST['case-type'];
$consultation_length = $_POST['consultation-length'];

// Insert into audit_records table
$stmt = $pdo->prepare("INSERT INTO audit_records (therapist_id, patient_id, case_type, consultation_length) 
                       VALUES (?, ?, ?, ?)");
if ($stmt->execute([$therapist_id, $patient_id, $case_type, $consultation_length])) {
    echo "Audit record saved successfully!";
} else {
    echo "Error saving audit record.";
}
?>
