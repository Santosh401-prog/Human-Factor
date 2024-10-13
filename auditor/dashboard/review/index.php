<?php
// Database connection (replace with your credentials)
$host = 'localhost';
$db   = 'care_system';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is to fetch therapists
if (isset($_GET['fetch']) && $_GET['fetch'] == 'therapists') {
    $query = "SELECT id, therapist_name FROM therapists";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['therapist_name'] . "</option>";
        }
    } else {
        echo "<option>No Therapists Available</option>";
    }
    exit;
}

// Check if the request is to fetch patients
if (isset($_GET['fetch']) && $_GET['fetch'] == 'patients') {
    $query = "SELECT id, patient_name FROM patients";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['patient_name'] . "</option>";
        }
    } else {
        echo "<option>No Patients Available</option>";
    }
    exit;
}

// Check if it's a POST request to fetch the form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $therapist = $_POST['therapist'];
    $patient = $_POST['patient'];
    $caseType = $_POST['caseType'];
    $consultationLength = $_POST['consultationLength'];

    $query = "SELECT t.therapist_name, COUNT(p.id) AS patient_count, 
                     GROUP_CONCAT(c.case_type SEPARATOR ', ') AS case_types, 
                     AVG(c.consultation_length) AS avg_consultation_length
              FROM therapists t
              JOIN cases c ON t.id = c.therapist_id
              JOIN patients p ON c.patient_id = p.id
              WHERE t.id = ? AND p.id = ? AND c.case_type = ?
              GROUP BY t.therapist_name";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $therapist, $patient, $caseType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['therapist_name'] . "</td>
                    <td>" . $row['patient_count'] . "</td>
                    <td>" . $row['case_types'] . "</td>
                    <td>" . $row['avg_consultation_length'] . "</td>
                    <td>" . $consultationLength . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No Data Found</td></tr>";
    }
    exit;
}
?>
