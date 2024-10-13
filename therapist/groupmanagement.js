
    const patientListDiv = document.getElementById('patient-list');
    const dropZone = document.getElementById('drop-zone');
    const groupForm = document.getElementById('group-form');
    const groupTableBody = document.querySelector('#group-table tbody');
    let selectedPatients = [];


    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.backgroundColor = '#e0f7fa';
    });//

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.backgroundColor = '#f9f9f9';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.backgroundColor = '#f9f9f9';

        const patientName = e.dataTransfer.getData('text/plain');
        if (!selectedPatients.includes(patientName)) {
            selectedPatients.push(patientName);
        }

        dropZone.textContent = selectedPatients.join(', ');
    });

    function addGroupToTable(groupName, groupType, selectedPatients) {
        const row = document.createElement('tr');
        const patientsText = selectedPatients.join(', ');
        row.innerHTML = `
            <td>${groupName}</td>
            <td>${groupType}</td>
            <td>${patientsText}</td>
            <td><input type="checkbox" class="follow-up-checkbox"></td>
            <td><button class="delete-btn">Delete</button></td>
        `;

        const followUpCheckbox = row.querySelector('.follow-up-checkbox');
        followUpCheckbox.addEventListener('change', function () {
            if (followUpCheckbox.checked) {
                row.classList.add('follow-up');
            } else {
                row.classList.remove('follow-up');
            }
        });

        row.querySelector('.delete-btn').addEventListener('click', function () {
            row.remove();
        });

        groupTableBody.appendChild(row);
    }

    groupForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const groupName = document.getElementById('group-name').value;
    const groupType = document.getElementById('group-type').value;

    if (selectedPatients.length > 0) {
        // Prepare data to send
        const groupData = {
            name: groupName,
            type: groupType,
            patients: selectedPatients
        };

        // Send data to the server
        fetch('therapist/create_group.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(groupData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                addGroupToTable(groupName, groupType, selectedPatients);
                groupForm.reset();
                selectedPatients = [];
                dropZone.textContent = 'Drop patients here to add them to the group';
            } else {
                alert('Failed to create group: ' + data.message);
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('An error occurred while creating the group. Please try again.');
        });
    } else {
        alert('Please drag and drop at least one patient into the group.');
    }
});

