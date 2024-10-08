document.getElementById('journalForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Capture form data
    const formData = new FormData(this);
    formData.append('action', 'add_journal_entry');

    // Send data to the PHP back-end
    fetch('patient_data.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Display success message
        this.reset(); // Reset the form after submission
    })
    .catch(error => console.error('Error submitting journal entry:', error));
});
