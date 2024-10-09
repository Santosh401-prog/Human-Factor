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

// Fetch previous journal entries
$stmt = $pdo->prepare("SELECT * FROM journal_entries ORDER BY entry_date DESC");
$stmt->execute();
$journalEntries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch last week's goals
$lastWeek = date('Y-m-d', strtotime('-1 week'));
$stmt = $pdo->prepare("SELECT * FROM goal WHERE created_at >= ?");
$stmt->execute([$lastWeek]);
$goals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
