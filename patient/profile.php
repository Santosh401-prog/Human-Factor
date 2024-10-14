<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="group-27">
    <title>Patient Profile | CaRe Web Service</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>
    <header>
        <h1>Patient Profile</h1>
    </header>

    <main>
        <!-- Photo Upload Section -->
        <section>
            <h2>Upload Profile Photo</h2>
            <form action="../php/upload_photo.php" method="post" enctype="multipart/form-data">
                Select images to upload:
                <input type="file" name="photos[]" multiple>
                <input type="submit" value="Upload Images" name="submit">
            </form>
        </section>

        <!-- Display most recent uploaded photo -->
        <section>
            <h2>Most Recent Uploaded Photo</h2>
            <div>
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

                // Fetch the most recent photo from the database
                $stmt = $pdo->query("SELECT file_name FROM photos ORDER BY id DESC LIMIT 1");
                $photo = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($photo)) {
                    echo '<img src="../uploads/' . $photo['file_name'] . '" alt="Profile Photo" width="150" style="margin: 10px;">';
                } else {
                    echo "<p>No photos uploaded yet.</p>";
                }
                ?>
            </div>
        </section>

        <!-- Profile Details -->
        <section>
            <h2>Your Profile Information</h2>
            <?php include '../php/profile.php'; ?> <!-- Fetch patient details -->
        </section>

        <!-- Set Goals Section -->
        <section>
            <h3>Set Goals for This Week</h3>
            <form id="goalForm" action="../php/set_goals.php" method="POST">
                <!-- Exercise Goal -->
                <label for="exerciseGoal">Exercise Goal (minutes):</label>
                <input type="number" id="exerciseGoal" name="goal_exercise" placeholder="e.g., 30" required>
            
                <!-- Sleep Goal -->
                <label for="sleepGoal">Sleep Goal (hours):</label>
                <input type="number" id="sleepGoal" name="goal_sleep" placeholder="e.g., 8" required>
            
                <!-- Eating Habit Goal -->
                <label for="eatingGoal">Eating Habit Goal:</label>
                <select id="eatingGoal" name="goal_eating" required>
                    <option value="healthy">Healthy</option>
                    <option value="balanced">Balanced</option>
                    <option value="unhealthy">Unhealthy</option>
                </select>

                <!-- Affirmation -->
                <label for="affirmation">Daily Affirmation:</label>
                <input type="text" id="affirmation" name="affirmation" placeholder="e.g., I will achieve my goals" required>

                <button type="submit" class="submit-btn">Set Goals</button>
            </form>
        </section>

        <h3>Current Goals</h3>
        <p><strong>Exercise:</strong> <span id="currentExerciseGoal">Not set</span> minutes</p>
        <p><strong>Sleep:</strong> <span id="currentSleepGoal">Not set</span> hours</p>
        <p><strong>Eating Habit:</strong> <span id="currentEatingGoal">Not set</span></p>
        <p><strong>Affirmation:</strong> <span id="currentAffirmation">Not set</span></p>
    </main>

    <footer>
        <p>&copy; 2024 CaRe Web Service</p>
    </footer>

    <script src="profile.js"></script>
    <button onclick="goBack()">Go Back</button>

    <script>
    function goBack() {
        window.history.back(); // This will go to the previous page in browser history
    }
    </script>
</body>
</html>
