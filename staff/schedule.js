window.onload = function() {
    loadPatientData();
    loadTherapistData();
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
                    <td><button onclick="scheduleAppointment(${patient.id}, '${patient.name}')">Schedule</button></td>
                `;
                patientTable.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching patient data:', error));
}

// Function to load available therapists
function loadTherapistData() {
    fetch('../php/therapist_data.php?action=fetch')
        .then(response => response.json())
        .then(data => {
            const therapistSelect = document.getElementById('therapist');
            therapistSelect.innerHTML = ''; // Clear existing options

            data.forEach(therapist => {
                const option = document.createElement('option');
                option.value = therapist.id;
                option.textContent = therapist.name;
                therapistSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching therapist data:', error));
}

// Function to show the appointment form for a selected patient
function scheduleAppointment(patientId, patientName) {
    document.getElementById('appointment-section').style.display = 'block';
    document.getElementById('patientName').textContent = patientName;
    document.getElementById('scheduleAppointmentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const appointmentDate = document.getElementById('appointmentDate').value;
        const appointmentTime = document.getElementById('appointmentTime').value;
        const therapistId = document.getElementById('therapist').value;

        const formData = new FormData();
        formData.append('action', 'schedule_appointment');
        formData.append('patient_id', patientId);
        formData.append('appointment_date', appointmentDate);
        formData.append('appointment_time', appointmentTime);
        formData.append('therapist_id', therapistId);

        // Send the appointment data to the server
        fetch('../php/patient_data.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            document.getElementById('appointment-section').style.display = 'none'; // Hide the form after submission
        })
        .catch(error => console.error('Error scheduling appointment:', error));
    });
}
