document.addEventListener('DOMContentLoaded', function() {
    // Fetch the list of patients and therapists from the server when the page loads
    fetch('record.php?fetch=patients')
        .then(response => response.json())
        .then(data => populatePatientSelect(data))
        .catch(error => console.error('Error fetching patient list:', error));

    fetch('record.php?fetch=therapists')
        .then(response => response.json())
        .then(data => populateTherapistSelect(data))
        .catch(error => console.error('Error fetching therapist list:', error));
});

// Populate the patient dropdown
function populatePatientSelect(patients) {
    const select = document.getElementById('patient-select');
    select.innerHTML = '';

    patients.forEach(patient => {
        const option = document.createElement('option');
        option.value = patient.username; // Assuming patient name is the identifier
        option.textContent = patient.username;
        select.appendChild(option);
    });
}

// Populate the therapist dropdown
function populateTherapistSelect(therapists) {
    const select = document.getElementById('therapist-select');
    therapists.forEach(therapist => {
        const option = document.createElement('option');
        option.value = therapist.username;
        option.textContent = therapist.username;
        select.appendChild(option);
    });
}

// Handle form submission to fetch filtered patient history
document.getElementById('patient-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const patientName = document.getElementById('patient-select').value;
    const therapistName = document.getElementById('therapist-select').value;

    // Build the query string for filtering
    const query = `record.php?patient=${patientName}&therapist=${therapistName}`;

    fetch(query)
        .then(response => response.json())
        .then(data => displayPatientHistory(data))
        .catch(error => console.error('Error fetching patient history:', error));
});

function displayPatientHistory(history) {
    const historyList = document.getElementById('history-list');
    historyList.innerHTML = '';

    if (history.length === 0) {
        historyList.innerHTML = '<li>No treatment history found.</li>';
    } else {
        history.forEach(item => {
            const listItem = document.createElement('li');
            listItem.textContent = `Date: ${item.created_at}, Therapist: ${item.therapist_name}, Case Type: ${item.case_type}, Consultation Length: ${item.consultation_length} minutes`;
            historyList.appendChild(listItem);
        });
    }
}

// Go Back button functionality
document.getElementById('go-back').addEventListener('click', function() {
    window.history.back(); // Takes the user back to the previous page
});
