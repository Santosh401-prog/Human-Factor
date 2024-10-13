<?php
// Database connection
$servername = "localhost";
$usernameDB = "root"; // Replace with your database username
$passwordDB = ""; // Replace with your database password
$dbname = "care_system"; // Replace with your database name

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for the action parameter (fetch or add)
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'fetch') {
    // Fetch patient data from the "patient" table
    $sql = "SELECT name, age, height, weight, gender, email, phone FROM patient";
    $result = $conn->query($sql);

    $patients = [];

    if ($result->num_rows > 0) {
        // Fetch each row as an associative array and add it to the $patients array
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
    }

    // Return patient data as JSON
    header('Content-Type: application/json');
    echo json_encode($patients);

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    // Handle form submission to add new patient (via POST request)
    $name = $_POST['name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepare and execute the SQL statement to insert patient data into the "patient" table
    $stmt = $conn->prepare("INSERT INTO patient (name, age, height, weight, gender, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('siddsss', $name, $age, $height, $weight, $gender, $email, $phone);

    if ($stmt->execute()) {
        echo "Patient added successfully";
    } else {
        echo "Error adding patient: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
