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

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_name = $_POST['username'];  // The name the user enters
    $entered_password = $_POST['password'];  // The user's password
    $entered_role = $_POST['role'];  // The user's role (patient, therapist, etc.)

    // Check if all form fields are filled out
    if (empty($entered_name) || empty($entered_password) || empty($entered_role)) {
        header("Location: ../login.html?error=All fields are required.");
        exit();
    }

    // Fetch user from 'users' table based on the entered username and role
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->execute([$entered_name, $entered_role]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and password matches
    if ($user && password_verify($entered_password, $user['password'])) {
        // If the user is a patient, fetch their details from the 'patients' table
        if ($entered_role === 'patient') {
            $stmt = $pdo->prepare("SELECT * FROM patients WHERE name = ?");
            $stmt->execute([$entered_name]);
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($patient) {
                // Store patient data in session
                $_SESSION['patient_name'] = $patient['name'];
                $_SESSION['patient_id'] = $patient['id'];
                $_SESSION['patient_email'] = $patient['email'];

                // Redirect to patient profile page
                header("Location: ../patient/patient.html");
                exit();
            } else {
                // Redirect back to login with error
                header("Location: ../login.html?error=No patient found with that name.");
                exit();
            }
        }

        // Handle other roles (therapist, staff, auditor)
        // Redirect based on the user's role
        switch ($user['role']) {
            case 'therapist':
                header("Location: ../therapist/therapistdashboard.html");
                break;
            case 'staff':
                header("Location: ../staff/staff_portal.html");
                break;
            case 'auditor':
                header("Location: ../auditor/dashboard/dash.html");
                break;
            default:
                header("Location: ../login.html");
                break;
        }
        exit();
    } else {
        // Invalid login credentials, redirect back to login with error message
        header("Location: ../login.html?error=Invalid login credentials.");
        exit();
    }
}
?>
