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
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}

// Get the form data
$therapist_name = $_POST['therapist'];
$patient_id = $_POST['patient'];
$case_type = $_POST['case-type'];
$consultation_length = $_POST['consultation-length'];

// Insert into audit_records table
$stmt = $pdo->prepare("INSERT INTO audit_records (therapist_name, patient_id, case_type, consultation_length) 
                       VALUES (?, ?, ?, ?)");
if ($stmt->execute([$therapist_name, $patient_id, $case_type, $consultation_length])) {
    // Fetch the number of patients and average consultation length for this therapist
    $numPatientsStmt = $pdo->prepare("SELECT COUNT(DISTINCT patient_id) AS num_patients FROM audit_records WHERE therapist_name = ?");
    $numPatientsStmt->execute([$therapist_name]);
    $numPatients = $numPatientsStmt->fetch(PDO::FETCH_ASSOC)['num_patients'];

    $avgLengthStmt = $pdo->prepare("SELECT AVG(consultation_length) AS avg_length FROM audit_records WHERE therapist_name = ?");
    $avgLengthStmt->execute([$therapist_name]);
    $avgConsultationLength = round($avgLengthStmt->fetch(PDO::FETCH_ASSOC)['avg_length'], 2);

    // Return the saved data along with aggregated data
    echo json_encode([
        'therapist_name' => $therapist_name,
        'num_patients' => $numPatients,
        'case_type' => $case_type,
        'avg_consultation_length' => $avgConsultationLength,
        'consultation_length' => $consultation_length
    ]);
} else {
    echo json_encode(['error' => 'Error saving audit record.']);
}
?>
