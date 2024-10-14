document.addEventListener('DOMContentLoaded', function() {
    fetchAppointments();
});

function fetchAppointments() {
    // Make AJAX request to the PHP file
    fetch('../staff/fetch_appointments.php')
        .then(response => response.json())
        .then(data => populateTable(data))
        .catch(error => console.error('Error fetching appointments:', error));
}

function populateTable(appointments) {
    const tableBody = document.querySelector('#appointmentsTable tbody');
    
    // Clear any existing rows in the table
    tableBody.innerHTML = '';

    // Loop through appointments and add rows to the table
    appointments.forEach(appointment => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${appointment.id}</td>
            <td>${appointment.patient_name}</td>
            <td>${appointment.therapist_name}</td>
            <td>${appointment.appointment_date}</td>
            <td>${appointment.appointment_time}</td>
        `;

        tableBody.appendChild(row);
    });
}
