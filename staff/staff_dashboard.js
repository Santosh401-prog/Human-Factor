window.onload = function() {
    loadPatientData();
};

// Function to load and display patient demographic data
function loadPatientData() {
    fetch('../php/patient_data.php?action=fetch')
        .then(response => response.json())
        .then(data => {
            const patientTable = document.getElementById('patientData');
            patientTable.innerHTML = ''; // Clear existing data

            data.forEach(patient => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${patient.name}</td>
                    <td>${patient.age}</td>
                    <td>${patient.height}</td>
                    <td>${patient.weight}</td>
                    <td>${patient.gender}</td>
                    <td>${patient.email}</td>
                    <td>${patient.phone}</td>
                `;
                patientTable.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching patient data:', error));
}

// Function to handle form submission for adding new patient
document.getElementById('addPatientForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    formData.append('action', 'add');

    fetch('patient_data.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        loadPatientData(); // Reload patient data after adding new patient
        this.reset(); // Reset form
    })
    .catch(error => console.error('Error adding patient:', error));
});
