<?php
// Database connection
include 'db_connection.php';

// Fetch patient data for the profile (common for both staff and patients)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'fetch_patient') {
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE email = ? OR phone = ?");
    $stmt->execute([$email, $phone]);
    $patient = $stmt->fetch();
    echo json_encode($patient);
    exit;
}

// Add new patient (staff only)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_patient') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("INSERT INTO patients (name, age, height, weight, gender, email, phone)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $age, $height, $weight, $gender, $email, $phone]);

    echo "Patient added successfully!";
    exit;
}

// Set weekly goals for patients (patient-specific operation)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'set_goals') {
    $exerciseGoal = $_POST['exerciseGoal'];
    $sleepGoal = $_POST['sleepGoal'];
    $eatingGoal = $_POST['eatingGoal'];
    $journalGoal = $_POST['journalGoal'];

    // Assuming patient is logged in
    $patient_id = 1; // Replace with actual patient ID from session

    $stmt = $pdo->prepare("INSERT INTO patient_goals (patient_id, exerciseGoal, sleepGoal, eatingGoal, journalGoal)
                           VALUES (?, ?, ?, ?, ?)
                           ON DUPLICATE KEY UPDATE
                           exerciseGoal = VALUES(exerciseGoal),
                           sleepGoal = VALUES(sleepGoal),
                           eatingGoal = VALUES(eatingGoal),
                           journalGoal = VALUES(journalGoal)");
    $stmt->execute([$patient_id, $exerciseGoal, $sleepGoal, $eatingGoal, $journalGoal]);

    echo "Goals updated successfully!";
    exit;
}

// Fetch weekly goals (for patients)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'fetch_goals') {
    $patient_id = 1; // Replace with actual patient ID from session
    $stmt = $pdo->prepare("SELECT * FROM patient_goals WHERE patient_id = ?");
    $stmt->execute([$patient_id]);
    $goals = $stmt->fetch();
    echo json_encode($goals);
    exit;
}

// Schedule an appointment for a patient (staff only)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'schedule_appointment') {
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, appointment_date, appointment_time)
                           VALUES (?, ?, ?)");
    $stmt->execute([$patient_id, $appointment_date, $appointment_time]);

    echo "Appointment scheduled successfully!";
    exit;
}

// Fetch patient demographic details for staff view
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'fetch_patients') {
    $stmt = $pdo->query("SELECT * FROM patients");
    $patients = $stmt->fetchAll();
    echo json_encode($patients); // Return JSON response with patient data
    exit;
}
?>


// Add new journal entry (patient-specific)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_journal_entry') {
    $patient_id = 1; // Replace with the actual logged-in patient's ID (from session or auth system)
    $entry_date = $_POST['entryDate'];
    $mood = $_POST['mood'];
    $sleep = $_POST['sleep'];
    $eating = $_POST['eating'];
    $exercise = $_POST['exercise'];
    $entry_text = $_POST['entryText'];

    $stmt = $pdo->prepare("INSERT INTO journal_entries (patient_id, entry_date, mood, sleep, eating, exercise, entry_text)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$patient_id, $entry_date, $mood, $sleep, $eating, $exercise, $entry_text]);

    echo "Journal entry added successfully!";
    exit;
}

// Fetch all journal entries for a patient (for the patient's history page)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'fetch_journal_entries') {
    $patient_id = 1; // Replace with actual patient ID
    $stmt = $pdo->prepare("SELECT * FROM journal_entries WHERE patient_id = ? ORDER BY entry_date DESC");
    $stmt->execute([$patient_id]);
    $entries = $stmt->fetchAll();
    echo json_encode($entries);
    exit;
}

