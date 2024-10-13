<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_journal_entry') {
    $entry_date = $_POST['entryDate'];
    $mood = $_POST['mood'];
    $sleep = $_POST['sleep'];
    $eating = $_POST['eating'];
    $exercise = $_POST['exercise'];
    $journal_text = $_POST['entryText'];

    // Insert the journal entry into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO journal_entries (entry_date, mood, sleep_hours, eating_habit, exercise_minutes, journal_text) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$entry_date, $mood, $sleep, $eating, $exercise, $journal_text]);

        echo "Journal entry added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>