// Sample data for therapists
const therapists = [
    {
        name: 'Therapist A',
        patients: 10,
        cases: ['Anxiety', 'Depression', 'PTSD'],
        consultationLength: 45 // average in minutes
    },
    {
        name: 'Therapist B',
        patients: 8,
        cases: ['OCD', 'Phobias', 'Bipolar Disorder'],
        consultationLength: 50
    },
    {
        name: 'Therapist C',
        patients: 12,
        cases: ['Schizophrenia', 'ADHD', 'Depression'],
        consultationLength: 40
    }
];

// Function to populate the table
const therapistTableBody = document.getElementById('therapist-overview-body');

function populateTherapistData() {
    therapists.forEach(therapist => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${therapist.name}</td>
            <td>${therapist.patients}</td>
            <td>${therapist.cases.join(', ')}</td>
            <td>${therapist.consultationLength}</td>
        `;
        therapistTableBody.appendChild(row);
    });
}

// Call the function to populate data on page load
populateTherapistData();

// Function to handle the 'Go Back' button action
function goBack() {
    window.history.back(); // Navigate back to the previous page
}
