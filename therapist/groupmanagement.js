document.addEventListener('click', function (e) {
    if (e.target.classList.contains('add-notes-btn')) {
        const groupName = e.target.dataset.groupName;
        document.getElementById('note-modal-title').textContent = `Add Note for Group: ${groupName}`;
        document.getElementById('group-name-hidden').value = groupName; // Set hidden input for group name
        document.getElementById('note-modal').style.display = 'block';
    }
});

// Hide the note modal
document.querySelector('.close-note-btn').addEventListener('click', () => {
    document.getElementById('note-modal').style.display = 'none';
});

// Save note function
document.getElementById('save-note-btn').addEventListener('click', function () {
    const groupName = document.getElementById('group-name-hidden').value;
    const note = document.getElementById('group-note').value;

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
            alert('Note saved successfully!');
            document.getElementById('note-modal').style.display = 'none';
            document.getElementById('group-note').value = '';
            // Reload group notes or refresh page to show the added note
        } else {
            alert('Failed to save note: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the note.');
    });
});


function loadGroupNotes(groupName) {
    fetch(`get_notes.php?group=${encodeURIComponent(groupName)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Process and display the notes as needed
                console.log(data.notes); // Replace this with actual display code
            } else {
                console.error('Failed to fetch notes:', data.message);
            }
        })
        .catch(error => console.error('Error fetching notes:', error));
}
