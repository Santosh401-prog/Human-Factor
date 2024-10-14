function populateDropdowns() {
    fetch('./get_users.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not OK');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);  // Log the response to check what is returned
            if (data.error) {
                alert(data.error);
            } else {
                const therapistSelect = document.getElementById('therapist');
                const patientSelect = document.getElementById('patient');

                // Populate therapists
                data.therapists.forEach(therapist => {
                    const option = document.createElement('option');
                    option.value = therapist.id;
                    option.textContent = therapist.username;
                    therapistSelect.appendChild(option);
                });

                // Populate patients
                data.patients.forEach(patient => {
                    const option = document.createElement('option');
                    option.value = patient.id;
                    option.textContent = patient.username;
                    patientSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            alert('Error fetching user data: ' + error.message);
        });
}
