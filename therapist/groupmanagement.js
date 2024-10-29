document.addEventListener('DOMContentLoaded', () => {
    loadPatientList();
});

function loadPatientList() {
    fetch('fetch-patients.php')
        .then(response => response.json())
        .then(data => populatePatientList(data))
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
        <td><button onclick="addNotes()">Add Notes</button></td>
        <td><button onclick="deleteGroup(this)">Delete</button></td>
    `;
    groupTableBody.appendChild(row);
}

function deleteGroup(button) {
    const row = button.parentNode.parentNode;
    row.remove();
}
