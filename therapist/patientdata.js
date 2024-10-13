function fetchPatients() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch-patients.php', true);
    xhr.onload = function() {
        console.log('Request completed. Status:', this.status); // Log request status
        if (this.status === 200) {
            console.log('Raw response:', this.responseText); // Log raw response
            try {
                const patients = JSON.parse(this.responseText);
                console.log('Fetched patients:', patients); // Log fetched patients
                populatePatientTable(patients);
            } catch (error) {
                console.error('Error parsing JSON:', error);
                console.error('Response was not valid JSON:', this.responseText); // Log invalid JSON response
            }
        } else {
            console.error('Failed to fetch patients. Status:', this.status);
        }
    };
    xhr.onerror = function() {
        console.error('Network error occurred');
    };
    xhr.send();
}


// Populate the patient table with the fetched data
function populatePatientTable(patients) {
    const patientTableBody = document.querySelector('#patient-table tbody');
    patientTableBody.innerHTML = ''; // Clear previous rows

    patients.forEach(patient => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${patient.name}</td>
            <td>${patient.age}</td>
            <td>
                <button class="view-btn" data-id="${patient.id}">View</button>
                <button class="add-note-btn" data-id="${patient.id}">Add Note</button>
            </td>
        `;
        patientTableBody.appendChild(row);
    });
}

// Call fetchPatients when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', fetchPatients);