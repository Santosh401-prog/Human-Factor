// Load patient details when the page loads
window.onload = function() {
    loadPatientDetails();
    loadCurrentGoals(); // Load the current goals for the patient
};

// Function to load and display patient details based on email or phone number
function loadPatientDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const email = urlParams.get('email');
    const phone = urlParams.get('phone');

    // Fetch patient details using email or phone
    fetch(`patient_data.php?action=fetch_patient&email=${email}&phone=${phone}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('patientName').textContent = data.name;
            document.getElementById('patientAddress').textContent = data.address;
            document.getElementById('patientPhone').textContent = data.phone;
            document.getElementById('patientEmail').textContent = data.email;

            // Load profile photo if available
            if (data.profile_photo) {
                document.getElementById('profilePhoto').src = data.profile_photo;
            }
        })
        .catch(error => console.error('Error fetching patient details:', error));
}

// Function to handle goal form submission and set goals for the week
document.getElementById('goalForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const exerciseGoal = document.getElementById('exerciseGoal').value;
    const sleepGoal = document.getElementById('sleepGoal').value;
    const eatingGoal = document.getElementById('eatingGoal').value;
    const journalGoal = document.getElementById('journalGoal').value;

    const formData = new FormData();
    formData.append('action', 'set_goals');
    formData.append('exerciseGoal', exerciseGoal);
    formData.append('sleepGoal', sleepGoal);
    formData.append('eatingGoal', eatingGoal);
    formData.append('journalGoal', journalGoal);

    // Send goals to the PHP backend to store them
    fetch('patient_data.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Notify the user that goals were updated
        loadCurrentGoals(); // Reload current goals after updating
    })
    .catch(error => console.error('Error setting goals:', error));
});

// Function to load and display the current goals from the database
function loadCurrentGoals() {
    fetch('patient_data.php?action=fetch_goals')
        .then(response => response.json())
        .then(data => {
            document.getElementById('currentExerciseGoal').textContent = data.exerciseGoal || 'Not set';
            document.getElementById('currentSleepGoal').textContent = data.sleepGoal || 'Not set';
            document.getElementById('currentEatingGoal').textContent = data.eatingGoal || 'Not set';
            document.getElementById('currentJournalGoal').textContent = data.journalGoal || 'Not set';
        })
        .catch(error => console.error('Error fetching current goals:', error));
}
