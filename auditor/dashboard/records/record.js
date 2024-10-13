// Fetch the list of patients and therapists from the server when the page loads
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/patients')
        .then(response => response.json())
        .then(data => populatePatientSelect(data))
        .catch(error => console.error('Error fetching patient list:', error));

    fetch('/api/therapists')
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
        option.value = patient.id;
        option.textContent = `${patient.first_name} ${patient.last_name}`;
        select.appendChild(option);
    });
}

// Populate the therapist dropdown
function populateTherapistSelect(therapists) {
    const select = document.getElementById('therapist-select');
    therapists.forEach(therapist => {
        const option = document.createElement('option');
        option.value = therapist.name;
        option.textContent = therapist.name;
        select.appendChild(option);
    });
}

// Handle form submission to fetch filtered patient history
document.getElementById('patient-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const patientId = document.getElementById('patient-select').value;
    const therapist = document.getElementById('therapist-select').value;
    const treatmentType = document.getElementById('treatment-type-select').value;

    const query = `/api/patient-history/${patientId}?therapist=${therapist}&treatment=${treatmentType}`;
    
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
            listItem.textContent = `Date: ${item.date}, Treatment: ${item.treatment}, Therapist: ${item.therapist}`;
            historyList.appendChild(listItem);
        });
    }
}

// Go Back button functionality
document.getElementById('go-back').addEventListener('click', function() {
    window.history.back(); // Takes the user back to the previous page
});
