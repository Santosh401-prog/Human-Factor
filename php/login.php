<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'care_system'; // Your database name
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check the database for the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->execute([$username, $role]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login, set session variables
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

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
    } else {
        // Invalid login
        echo "Invalid username, password, or role.";
    }
}
?>
