document.addEventListener('DOMContentLoaded', () => {
    loadPatientList();
});

function loadPatientList() {
    fetch('fetch_patients.php')
        .then(response => response.json())
        .then(data => {
            console.log('Fetched patients:', data);
            if (Array.isArray(data)) {
                populatePatientList(data);
            } else {
                console.error('Unexpected data format:', data);
            }
        })
        .catch(error => console.error('Error fetching patients:', error));
}

function populatePatientList(patients) {
    const patientListDiv = document.getElementById('patient-list');
    patientListDiv.innerHTML = '';

    patients.forEach(patient => {
        const patientDiv = document.createElement('div');
        patientDiv.textContent = patient.name;
        patientDiv.setAttribute('draggable', true);
        patientDiv.classList.add('draggable-patient');
        patientDiv.dataset.id = patient.id;

        patientDiv.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text', JSON.stringify({ id: patient.id, name: patient.name }));
        });

        patientListDiv.appendChild(patientDiv);
    });
}

const dropZone = document.getElementById('drop-zone');
const selectedPatients = [];

dropZone.addEventListener('dragover', (e) => e.preventDefault());
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    const patient = JSON.parse(e.dataTransfer.getData('text'));
    if (!selectedPatients.find(p => p.id === patient.id)) {
        selectedPatients.push(patient);
    }
    dropZone.textContent = selectedPatients.map(p => p.name).join(', ');
});

document.getElementById('group-form').addEventListener('submit', (e) => {
    e.preventDefault();

    const groupName = document.getElementById('group-name').value;
    const groupType = document.getElementById('group-type').value;
    
    if (selectedPatients.length === 0) {
        alert('Please add at least one patient.');
        return;
    }

    const groupData = {
        name: groupName,
        type: groupType,
        patients: selectedPatients.map(p => p.id)
    };

    fetch('create_group.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(groupData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Group created successfully');
            addGroupToTable(groupName, groupType, selectedPatients);
            selectedPatients.length = 0;
            dropZone.textContent = 'Drop patients here to add them to the group';
        } else {
            alert('Error creating group');
        }
    })
    .catch(error => console.error('Error:', error));
});

function addGroupToTable(name, type, patients) {
    const groupTableBody = document.querySelector('#group-table tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${name}</td>
        <td>${type}</td>
        <td>${patients.map(p => p.name).join(', ')}</td>
        <td><button onclick="addNotes('${name}')">Add Notes</button></td>
        <td><button onclick="deleteGroup('${name}', this)">Delete</button></td>
    `;
    groupTableBody.appendChild(row);
}

function addNotes(groupName) {
    const note = prompt(`Add a note for the group: ${groupName}`);
    if (note) {
        fetch('save_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ groupName, note })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Note added successfully');
            } else {
                alert('Failed to add note');
            }
        })
        .catch(error => console.error('Error adding note:', error));
    }
}

function deleteGroup(groupName, button) {
    fetch('delete_group.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ groupName })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Group deleted successfully');
            const row = button.parentNode.parentNode;
            row.remove();
        } else {
            alert('Failed to delete group');
        }
    })
    .catch(error => console.error('Error deleting group:', error));
}
