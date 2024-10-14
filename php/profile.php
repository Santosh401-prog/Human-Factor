<?php
session_start();

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

// Check if the patient is logged in by verifying the session
if (isset($_SESSION['patient_name'])) {
    $logged_in_patient_name = $_SESSION['patient_name'];
    
    // Fetch the patient's profile data based on the name
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE name = ?");
    $stmt->execute([$logged_in_patient_name]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($patient) {
        // Display the patient profile
        echo "<p><strong>Name:</strong> " . htmlspecialchars($patient['name']) . "</p>";
        echo "<p><strong>Age:</strong> " . htmlspecialchars($patient['age']) . "</p>";
        echo "<p><strong>Height:</strong> " . htmlspecialchars($patient['height']) . " cm</p>";
        echo "<p><strong>Weight:</strong> " . htmlspecialchars($patient['weight']) . " kg</p>";
        echo "<p><strong>Gender:</strong> " . htmlspecialchars($patient['gender']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($patient['email']) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($patient['phone']) . "</p>";
    } else {
        echo "No matching patient profile found.";
    }
} else {
    echo "You are not logged in.";
}
?>
