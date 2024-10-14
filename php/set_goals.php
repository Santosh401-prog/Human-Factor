<?php
session_start();

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
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Check if the patient is logged in
if (!isset($_SESSION['patient_id'])) {
    echo json_encode(['success' => false, 'message' => 'Patient not logged in']);
    exit();
}

// Handle POST requests to set the goals
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $goal_exercise = $_POST['goal_exercise'];
    $goal_sleep = $_POST['goal_sleep'];
    $goal_eating = $_POST['goal_eating'];
    $affirmation = $_POST['affirmation'];

    try {
        $stmt = $pdo->prepare("INSERT INTO goals (goal_exercise, goal_sleep, goal_eating, affirmation) VALUES (?, ?, ?, ?)");
        $stmt->execute([$goal_exercise, $goal_sleep, $goal_eating, $affirmation]);

        echo json_encode(['success' => true, 'message' => 'Goals saved successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error saving goals: ' . $e->getMessage()]);
    }
    exit();
}

// Handle GET requests to fetch the current goals
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $stmt = $pdo->prepare("SELECT goal_exercise, goal_sleep, goal_eating, affirmation FROM goals ORDER BY created_at DESC LIMIT 1");
        $stmt->execute();
        $goal = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($goal) {
            echo json_encode(['success' => true, 'goals' => $goal]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No goals found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching goals: ' . $e->getMessage()]);
    }
    exit();
}
