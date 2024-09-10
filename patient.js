document.getElementById('journalForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting

    // Capture form data
    const date = document.getElementById('entryDate').value;
    const mood = document.querySelector('input[name="mood"]:checked').value; // Get selected mood
    const sleep = document.getElementById('sleep').value;
    const eating = document.getElementById('eating').value;
    const exercise = document.getElementById('exercise').value;
    const entryText = document.getElementById('entryText').value;

    // Create an entry object
    const entry = {
        date: date,
        mood: mood,
        sleep: sleep,
        eating: eating,
        exercise: exercise,
        journalEntry: entryText
    };

    // Save the entry to last week's activity
    localStorage.setItem('lastWeekActivity', JSON.stringify(entry)); // Store the entry as last week's activity

    // Save the journal history to localStorage
    let journalHistory = JSON.parse(localStorage.getItem('journalHistory')) || [];
    journalHistory.push(entry); // Add the new entry to the history
    localStorage.setItem('journalHistory', JSON.stringify(journalHistory)); // Save the updated history

    // Clear the form
    document.getElementById('journalForm').reset();
});
