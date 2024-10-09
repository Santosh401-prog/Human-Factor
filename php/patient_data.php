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

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert data into the patients table
    try {
        $stmt = $pdo->prepare("INSERT INTO patient (name, age, height, weight, gender, email, phone)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $age, $height, $weight, $gender, $email, $phone]);

        // Success message
        echo "Patient added successfully!";
    } catch (PDOException $e) {
        // Show any errors that occur during the insertion
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Form not submitted.";
}
?>
