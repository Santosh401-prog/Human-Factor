document.addEventListener('DOMContentLoaded', function() {
    fetchJournalEntries();
});

function fetchJournalEntries() {
    fetch('history.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                const journalHistoryBody = document.getElementById('journal-history-body');

                // Clear any existing entries in the table
                journalHistoryBody.innerHTML = '';

                data.forEach(entry => {
                    const rowHTML = `
                        <tr>
                            <td>${entry.entry_date}</td>
                            <td>${entry.mood}</td>
                            <td>${entry.sleep_hours}</td>
                            <td>${entry.eating_habit}</td>
                            <td>${entry.exercise_minutes}</td>
                            <td>${entry.journal_text}</td>
                        </tr>
                    `;

                    // Add the row to the table
                    journalHistoryBody.innerHTML += rowHTML;
                });
            }
        })
        .catch(error => console.error('Error fetching journal entries:', error));
}
