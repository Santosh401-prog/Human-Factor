// Load patient details when the page loads
window.onload = function() {
    // loadPatientDetails();
    loadCurrentGoals(); // Load the current goals for the patient
};

// Function to load current goals and display them
function loadCurrentGoals() {
    fetch('../php/set_goals.php') // This PHP file will return the current goals
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate the current goals
                document.getElementById('currentExerciseGoal').textContent = data.goals.goal_exercise;
                document.getElementById('currentSleepGoal').textContent = data.goals.goal_sleep;
                document.getElementById('currentEatingGoal').textContent = data.goals.goal_eating;
                document.getElementById('currentAffirmation').textContent = data.goals.affirmation;
            } else {
                alert('Failed to load current goals.');
            }
        })
        .catch(error => console.error('Error fetching goals:', error));
}

// Handle form submission for setting goals
document.getElementById('goalForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting in the traditional way

    const formData = new FormData(this); // Create a form data object for the form

    fetch('../php/set_goals.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Alert success or error message from the server
        loadCurrentGoals(); // Reload the current goals to reflect the updated ones
    })
    .catch(error => console.error('Error setting goals:', error));
});

fetch('../php/set_goals.php')
    .then(response => response.text()) // Get the raw response
    .then(data => {
        console.log('Raw response:', data); // Log the raw response
        try {
            const jsonData = JSON.parse(data); // Parse as JSON
            if (jsonData.success) {
                document.getElementById('currentExerciseGoal').textContent = jsonData.goals.goal_exercise;
                document.getElementById('currentSleepGoal').textContent = jsonData.goals.goal_sleep;
                document.getElementById('currentEatingGoal').textContent = jsonData.goals.goal_eating;
                document.getElementById('currentAffirmation').textContent = jsonData.goals.affirmation;
            } else {
                alert(jsonData.message); // Show the error message from the response
            }
        } catch (error) {
            console.error('Error parsing JSON:', error, data); // Log any JSON parsing errors
        }
    })
    .catch(error => console.error('Error fetching goals:', error));
