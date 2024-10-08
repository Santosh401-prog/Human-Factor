<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'username', 'password', 'staff_portal');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patients for the dropdown
$sql = "SELECT id, first_name, last_name FROM patients";
$patients = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    
    // Insert appointment into the database
    $sql = "INSERT INTO appointments (id, appointment_date, appointment_time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $patient_id, $appointment_date, $appointment_time);
    if ($stmt->execute()) {
        echo "Appointment scheduled successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <style>
        .container { width: 500px; margin: 100px auto; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; }
        input[type="submit"] { background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Schedule Appointment</h1>
        <form action="schedule_appointment.php" method="POST">
            <label for="patient">Select Patient:</label>
            <select name="patient_id" id="patient" required>
                <?php while($row = $patients->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="appointment_date">Appointment Date:</label>
            <input type="date" name="appointment_date" id="appointment_date" required>

            <label for="appointment_time">Appointment Time:</label>
            <input type="time" name="appointment_time" id="appointment_time" required>

            <input type="submit" value="Schedule Appointment">
        </form>
    </div>
</body>
</html>