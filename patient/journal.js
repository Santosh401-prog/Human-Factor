// document.getElementById('journalForm').addEventListener('submit', function(event) {
//     event.preventDefault(); // Prevent the default form submission behavior

//     // Capture form data
//     const formData = new FormData(this);
//     formData.append('action', 'add_journal_entry');

//     // Send data to the PHP back-end
//     fetch('../php/journal.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.text())
//     .then(data => {
//         alert(data); // Display success message
//         this.reset(); // Reset the form after submission
//     })
//     .catch(error => console.error('Error submitting journal entry:', error));
// });


document.getElementById('journalForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    // Create a FormData object to hold the form data
    const formData = new FormData(this);

    // Send the form data to the PHP backend
    fetch('../php/journal.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Show success or error message
        // Optionally reset the form
        this.reset();
    })
    .catch(error => console.error('Error submitting the journal entry:', error));
});
