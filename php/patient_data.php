<?php
// Enable error reporting to help debug
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

// Handle different actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add') {
        // Add new patient
        $stmt = $pdo->prepare("INSERT INTO patients (name, age, height, weight, gender, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['age'], $_POST['height'], $_POST['weight'], $_POST['gender'], $_POST['email'], $_POST['phone']]);
        echo "Patient added successfully!";
    } elseif ($_POST['action'] === 'schedule_appointment') {
        // Schedule an appointment
        $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, appointment_date, appointment_time, therapist_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['patient_id'], $_POST['appointment_date'], $_POST['appointment_time'], $_POST['therapist_id']]);
        echo "Appointment scheduled successfully!";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'fetch') {
    // Fetch all patients
    $stmt = $pdo->query("SELECT * FROM patients");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
?>