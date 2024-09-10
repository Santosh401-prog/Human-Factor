document.getElementById('goalForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Capture the goals
    const exerciseGoal = document.getElementById('exerciseGoal').value;
    const sleepGoal = document.getElementById('sleepGoal').value;
    const eatingGoal = document.getElementById('eatingGoal').value;
    const journalGoal = document.getElementById('journalGoal').value;

    // Store the goals in localStorage
    localStorage.setItem('exerciseGoal', exerciseGoal);
    localStorage.setItem('sleepGoal', sleepGoal);
    localStorage.setItem('eatingGoal', eatingGoal);
    localStorage.setItem('journalGoal', journalGoal);

    // Display the goals after saving
    displayGoals();
});

// Function to display the goals
function displayGoals() {
    const exerciseGoal = localStorage.getItem('exerciseGoal') || 'Not set';
    const sleepGoal = localStorage.getItem('sleepGoal') || 'Not set';
    const eatingGoal = localStorage.getItem('eatingGoal') || 'Not set';
    const journalGoal = localStorage.getItem('journalGoal') || 'Not set';

    document.getElementById('currentExerciseGoal').textContent = exerciseGoal;
    document.getElementById('currentSleepGoal').textContent = sleepGoal;
    document.getElementById('currentEatingGoal').textContent = eatingGoal;
    document.getElementById('currentJournalGoal').textContent = journalGoal;
}

// Load and display goals when the page loads
window.onload = function() {
    displayGoals();
};


// // Show saved goal on page load
// window.onload = function() {
//     displayGoal();

//     // Display last week's activities
//     const lastWeekActivity = localStorage.getItem('lastWeekActivity');
//     if (lastWeekActivity) {
//         document.getElementById('last-week-activities').innerHTML = lastWeekActivity;
//     }
// };
