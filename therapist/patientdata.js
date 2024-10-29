function fetchPatients() {
    fetch('fetch-patients.php')
        .then(response => response.json())
        .then(data => populatePatientTable(data))
        .catch(error => console.error('Error fetching patients:', error));
}

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

// Fetch patients on page load
document.addEventListener('DOMContentLoaded', fetchPatients);
