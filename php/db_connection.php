<?php
// Database connection settings
$host = 'localhost'; // XAMPP uses 'localhost' for local server
$dbname = 'care_system'; // Your database name
$username = 'root'; // Default XAMPP username is 'root'
$password = ''; // Leave blank unless you've set a MySQL password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch (PDOException $e) {
    // If there's an error, display it
    die("Database connection failed: " . $e->getMessage());
}
?>

