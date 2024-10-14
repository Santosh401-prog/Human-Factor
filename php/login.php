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
    $entered_name = $_POST['username']; // The name patient enters
    $entered_password = $_POST['password']; // The patient's password
    
    // Fetch the patient by name
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE name = ?");
    $stmt->execute([$entered_name]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if patient exists and password matches
    if ($patient && password_verify($entered_password, $patient['password'])) {
        // Store patient name and ID in session
        $_SESSION['patient_name'] = $patient['name'];
        $_SESSION['patient_id'] = $patient['id'];

        // Redirect to profile page
        header("Location: ../patient/profile.html");
        exit();
    } else {
        echo "Invalid login credentials. Please try again.";
    }




        // Redirect based on the user's role
        switch ($user['role']) {
            case 'patient':
                header("Location: ../patient/login.html");
                break;
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
    }else {
        // Invalid login
        echo "Invalid username, password, or role.";
    }

?>
