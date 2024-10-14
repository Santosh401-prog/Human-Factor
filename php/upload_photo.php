<?php
session_start();

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

// Handle file upload logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photos'])) {
    $target_dir = "../uploads/"; // Ensure this is the correct path relative to your HTML
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
    }

    $uploadOk = 1; // Flag to track if the upload is successful

    // Loop through each uploaded file
    foreach ($_FILES['photos']['name'] as $key => $name) {
        $tmp_name = $_FILES['photos']['tmp_name'][$key];
        $file_size = $_FILES['photos']['size'][$key];
        $file_type = $_FILES['photos']['type'][$key];

        // Generate a unique filename
        $unique_name = uniqid('photo_', true) . '.' . strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $target_file = $target_dir . $unique_name;

        // Check if file is an actual image
        $check = getimagesize($tmp_name);
        if ($check !== false) {
            // Check file size (optional, example: limit to 2MB)
            if ($file_size > 2000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow only certain file formats
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // If all checks pass, move the uploaded file
            if ($uploadOk == 1) {
                if (move_uploaded_file($tmp_name, $target_file)) {
                    // Save the file name to the database
                    $stmt = $pdo->prepare("INSERT INTO photos (file_name) VALUES (:file_name)");
                    $stmt->bindParam(':file_name', $unique_name);
                    $stmt->execute();
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            echo "File is not a valid image.";
        }
    }

    // Redirect back to the profile page after uploading
    header("Location: ../patient/profile.php"); // Adjust to the correct page path
    exit();
}
?>
