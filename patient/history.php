<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal History | CaRe Web Service</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>
    <header>
        <h1>Journal History</h1>
    </header>

    <main>
        <!-- Last Week's Goals -->
        <section>
            <h2>Last Week's Goals</h2>
            <table>
                <thead>
                    <tr>
                        <th>Exercise Goal (minutes)</th>
                        <th>Sleep Goal (hours)</th>
                        <th>Eating Habit Goal</th>
                        <th>Date Set</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the fetch_history.php script from the correct folder
                    include '../php/fetch_history.php'; // Adjust this path as necessary

                    if (!empty($goals)) {
                        foreach ($goals as $goal) {
                            echo "<tr>
                                    <td>{$goal['goal_exercise']}</td>
                                    <td>{$goal['goal_sleep']}</td>
                                    <td>{$goal['goal_eating']}</td>
                                    <td>{$goal['created_at']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No goals set for last week.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Previous Journal Entries -->
        <section>
            <h2>Previous Journal Entries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Mood</th>
                        <th>Sleep Duration (hours)</th>
                        <th>Eating Habit</th>
                        <th>Exercise (minutes)</th>
                        <th>Journal Entry</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($journalEntries)) {
                        foreach ($journalEntries as $entry) {
                            echo "<tr>
                                    <td>{$entry['entry_date']}</td>
                                    <td>{$entry['mood']}</td>
                                    <td>{$entry['sleep_hours']}</td> <!-- Change here -->
                                    <td>{$entry['eating_habit']}</td>
                                    <td>{$entry['exercise_minutes']}</td>
                                    <td>{$entry['journal_text']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No journal entries found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

    </main>
    <button onclick="goBack()">Go Back</button>

    <script>
    function goBack() {
    window.history.back(); // This will go to the previous page in browser history
}</script>
    <footer>
        <p>&copy; 2024 CaRe Web Service</p>
    </footer>
</body>
</html>
