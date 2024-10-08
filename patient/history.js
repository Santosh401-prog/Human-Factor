// Load past entries and last week's activities from localStorage when the page loads
window.onload = function() {
    // Retrieve the last week's activities
    const lastWeekActivity = JSON.parse(localStorage.getItem('lastWeekActivity'));
    if (lastWeekActivity) {
        appendToTable('last-week-activities-body', lastWeekActivity);
    }

    // Retrieve past journal entries
    const journalHistory = JSON.parse(localStorage.getItem('journalHistory')) || [];
    
    // Append each journal entry to the table
    journalHistory.forEach(function(entry) {
        appendToTable('journal-history-body', entry);
    });
};

// Function to append data to the table
function appendToTable(tableId, entry) {
    const tableBody = document.getElementById(tableId);

    const row = document.createElement('tr');

    // Assuming the entry is an object with these properties
    row.innerHTML = `
        <td>${entry.date}</td>
        <td>${capitalizeMood(entry.mood)}</td>
        <td>${entry.sleep}</td>
        <td>${entry.eating}</td>
        <td>${entry.exercise}</td>
        <td>${entry.journalEntry}</td>
    `;

    tableBody.appendChild(row);
}

// Function to capitalize mood
function capitalizeMood(mood) {
    return mood.charAt(0).toUpperCase() + mood.slice(1);
}
