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

function filterPatients() {
    const searchValue = document.getElementById('search').value.toLowerCase();
    const patientRows = document.querySelectorAll('#patient-table tbody tr');

    patientRows.forEach(row => {
        const patientName = row.querySelector('td:first-child').textContent.toLowerCase();
        if (patientName.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
// Show the note modal when the "Add Note" button is clicked
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('add-note-btn')) {
        const patientId = e.target.getAttribute('data-id');
        document.getElementById('note-patient-name').textContent = patientId;
        document.getElementById('note-modal').style.display = 'block';
        document.getElementById('save-note-btn').dataset.patientId = patientId;
    }
});

// Hide the note modal
document.querySelector('.close-note-btn').addEventListener('click', () => {
    document.getElementById('note-modal').style.display = 'none';
});

// Save note function
document.getElementById('save-note-btn').addEventListener('click', function () {
    const patientId = this.dataset.patientId;
    const note = document.getElementById('patient-note').value;

    fetch('save_note.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ patientId, note })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Note saved successfully!');
            document.getElementById('note-modal').style.display = 'none';
            document.getElementById('patient-note').value = '';
        } else {
            alert('Failed to save note: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the note.');
    });
});

// Call fetchPatients when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', fetchPatients);
