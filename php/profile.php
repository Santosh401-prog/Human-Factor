<?php
session_start();

// Check if the patient is logged in
if (!isset($_SESSION['patient_id'])) {
    // If the patient is not logged in, redirect to the login page
    header("Location: ../login/login.html");
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
    die("Could not connect to the database: " . $e->getMessage());
}

// Fetch the patient data from the 'patients' table using the session patient ID
$patient_id = $_SESSION['patient_id'];
$stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->execute([$patient_id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

// Display the patient's details
if ($patient) {
    echo "<h1>Welcome, " . htmlspecialchars($patient['name']) . "</h1>";
    echo "<p>Age: " . htmlspecialchars($patient['age']) . "</p>";
    echo "<p>Height: " . htmlspecialchars($patient['height']) . "</p>";
    echo "<p>Weight: " . htmlspecialchars($patient['weight']) . "</p>";
    echo "<p>Gender: " . htmlspecialchars($patient['gender']) . "</p>";
    echo "<p>Email: " . htmlspecialchars($patient['email']) . "</p>";
    echo "<p>Phone: " . htmlspecialchars($patient['phone']) . "</p>";
} else {
    echo "Error: Patient details not found.";
}
?>
