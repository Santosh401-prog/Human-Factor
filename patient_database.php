<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}

// Connect to database
$conn = new mysqli('localhost', 'username', 'password', 'staff_portal');

// Check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patients
$sql = "SELECT first_name, last_name, age, height, weight, gender FROM patients";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Database</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Patient Database</h1>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Height (cm)</th>
            <th>Weight (kg)</th>
            <th>Gender</th>
        </tr>
        <?php if ($result->num_rows > 0) : ?>
            <?php while($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['height']; ?></td>
                    <td><?php echo $row['weight']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr><td colspan="6">No patients found.</td></tr>    
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
