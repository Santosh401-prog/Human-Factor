<?php
// Database connection
$host = 'localhost';
$dbname = 'care_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Fetch patients
if (isset($_GET['fetch']) && $_GET['fetch'] == 'patients') {
    $query = "SELECT username FROM users WHERE role = 'patient'";
    $stmt = $pdo->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit();
}

// Fetch therapists
if (isset($_GET['fetch']) && $_GET['fetch'] == 'therapists') {
    $query = "SELECT username FROM users WHERE role = 'therapist'";
    $stmt = $pdo->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit();
}

// Fetch treatment history from audit_records based on patient and therapist filters
if (isset($_GET['patient']) || isset($_GET['therapist'])) {
    $query = "SELECT * FROM audit_records WHERE 1=1";
    $params = [];

    if (!empty($_GET['patient'])) {
        $query .= " AND patient_id = ?";
        $params[] = $_GET['patient'];
    }
    if (!empty($_GET['therapist'])) {
        $query .= " AND therapist_name = ?";
        $params[] = $_GET['therapist'];
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($history);
    exit();
}

echo json_encode(['error' => 'Invalid request']);
?>
