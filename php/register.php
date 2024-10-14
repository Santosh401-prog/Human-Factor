<?php
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

// Process the registration form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newUsername = $_POST['newUsername'];
    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT); // Hash the password
    $newRole = $_POST['newRole'];

    // First, check if the username already exists in 'users' table
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$newUsername]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        // Username already exists, redirect back with error message
        header("Location: ../login/create_account.html?error=username_exists");
        exit();
    } else {
        // Now check if the patient name exists in the 'patient' table (if the role is 'patient')
        if ($newRole === 'patient') {
            $stmt = $pdo->prepare("SELECT * FROM patients WHERE name = ?");
            $stmt->execute([$newUsername]);
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($patient) {
                // Patient exists, now create an account in 'users' table
                $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                $stmt->execute([$newUsername, $newPassword, $newRole]);

                // Redirect back to the registration page with success message
                header("Location: ../login/create_account.html?success=1");
                exit();
            } else {
                // No matching patient name in 'patient' table, display an error
                header("Location: ../login/create_account.html?error=patient_not_found");
                exit();
            }
        } else {
            // For other roles, directly create the account
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$newUsername, $newPassword, $newRole]);

            // Redirect back to the registration page with success message
            header("Location: ../login/create_account.html?success=1");
            exit();
        }
    }
}
?>
