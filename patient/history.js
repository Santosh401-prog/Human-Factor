document.addEventListener('DOMContentLoaded', function() {
    fetchJournalEntries();
});

function fetchJournalEntries() {
    fetch('./history.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                const journalHistoryBody = document.getElementById('journal-history-body');
                journalHistoryBody.innerHTML = ''; // Clear previous entries

                // Populate the table with journal entries
                data.forEach(entry => {
                    const rowHTML = `
                        <tr>
                            <td>${entry.entry_date}</td>
                            <td>${entry.mood}</td>
                            <td>${entry.sleep_duration}</td>
                            <td>${entry.eating_habit}</td>
                            <td>${entry.exercise_minutes}</td>
                            <td>${entry.journal_text}</td>
                        </tr>
                    `;
                    journalHistoryBody.innerHTML += rowHTML;
                });
            }
        })
        .catch(error => console.error('Error fetching journal entries:', error));
}
