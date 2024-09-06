// Set the goal for this week and save it to localStorage
document.getElementById('goalForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const goal = document.getElementById('goalInput').value;
    localStorage.setItem('weeklyGoal', goal); // Store the goal in localStorage
    displayGoal();
    document.getElementById('goalForm').reset();
});

// Display the goal from localStorage
function displayGoal() {
    const savedGoal = localStorage.getItem('weeklyGoal');
    if (savedGoal) {
        document.getElementById('currentGoal').textContent = savedGoal;
    }
}

// Show saved goal on page load
window.onload = function() {
    displayGoal();

    // Display last week's activities
    const lastWeekActivity = localStorage.getItem('lastWeekActivity');
    if (lastWeekActivity) {
        document.getElementById('last-week-activities').innerHTML = lastWeekActivity;
    }
};
