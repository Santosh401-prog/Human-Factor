// Sample data for patient records (anonymized IDs)
const patientRecords = [
    { id: 'PAT001', lastConsultation: '2024-09-20', visits: 5, therapist: 'Therapist A', status: 'Ongoing' },
    { id: 'PAT002', lastConsultation: '2024-09-15', visits: 3, therapist: 'Therapist B', status: 'Completed' },
    { id: 'PAT003', lastConsultation: '2024-09-25', visits: 7, therapist: 'Therapist C', status: 'Ongoing' }
];

// Function to populate patient records table
function populatePatientRecords() {
    const patientRecordsTableBody = document.getElementById('patientRecordsTableBody');

    patientRecords.forEach(record => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${record.id}</td>
            <td>${record.lastConsultation}</td>
            <td>${record.visits}</td>
            <td>${record.therapist}</td>
            <td>${record.status}</td>
        `;
        patientRecordsTableBody.appendChild(row);
    });
}

// Call the function to populate data on page load
document.addEventListener('DOMContentLoaded', populatePatientRecords);
function goBack() {
    window.history.back(); 
}