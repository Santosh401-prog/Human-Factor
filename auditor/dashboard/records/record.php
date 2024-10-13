<?php
{
    "php.validate.executablePath": ""
}
// Database connection
$host = 'localhost'; // Your database host
$db   = 'care_system'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patients
if ($_SERVER['REQUEST_METHOD'] == 'GET' && strpos($_SERVER['REQUEST_URI'], '/api/patients') !== false) {
    $query = "SELECT id, first_name, last_name FROM patients";
    $result = $conn->query($query);

    $patients = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
    }
    echo json_encode($patients);
    exit;
}

// Fetch therapists
if ($_SERVER['REQUEST_METHOD'] == 'GET' && strpos($_SERVER['REQUEST_URI'], '/api/therapists') !== false) {
    $query = "SELECT name FROM therapists";
    $result = $conn->query($query);

    $therapists = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $therapists[] = $row;
        }
    }
    echo json_encode($therapists);
    exit;
}

// Fetch patient treatment history
if ($_SERVER['REQUEST_METHOD'] == 'GET' && preg_match('/\/api\/patient-history\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $patientId = $matches[1];
    $therapist = isset($_GET['therapist']) ? $_GET['therapist'] : '';
    $treatment = isset($_GET['treatment']) ? $_GET['treatment'] : '';

    // SQL query to fetch treatment history based on optional filters
    $query = "SELECT treatment.date, treatment.treatment, therapists.name AS therapist 
              FROM treatment 
              JOIN therapists ON treatment.therapist_id = therapists.id 
              WHERE treatment.patient_id = ?";
    
    if (!empty($therapist)) {
        $query .= " AND therapists.name = ?";
    }
    if (!empty($treatment)) {
        $query .= " AND treatment.treatment = ?";
    }

    $stmt = $conn->prepare($query);
    
    if (!empty($therapist) && !empty($treatment)) {
        $stmt->bind_param('iss', $patientId, $therapist, $treatment);
    } elseif (!empty($therapist)) {
        $stmt->bind_param('is', $patientId, $therapist);
    } elseif (!empty($treatment)) {
        $stmt->bind_param('is', $patientId, $treatment);
    } else {
        $stmt->bind_param('i', $patientId);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $history = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
    }
    echo json_encode($history);
    exit;
}

$conn->close();
?>
