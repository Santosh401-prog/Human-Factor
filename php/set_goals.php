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

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goal_exercise = $_POST['goal_exercise'];
    $goal_sleep = $_POST['goal_sleep'];
    $goal_eating = $_POST['goal_eating'];

    // Insert the goals into the 'goals' table
    try {
        $stmt = $pdo->prepare("INSERT INTO goal (goal_exercise, goal_sleep, goal_eating) 
                               VALUES (?, ?, ?)");
        $stmt->execute([$goal_exercise, $goal_sleep, $goal_eating]);

        // After successful insertion, redirect back to the profile page
        header("Location: ../patient/profile.html?success=1");
        exit();
    } catch (PDOException $e) {
        // Handle any errors during the insertion
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No data submitted.";
}
?>
