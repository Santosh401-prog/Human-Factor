document.addEventListener('DOMContentLoaded', function() {
    fetchJournalEntries();
});

function fetchJournalEntries() {
    fetch('./history.php')  // Ensure this is pointing to the correct PHP file
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log the data returned from the PHP backend

            if (data.error) {
                alert(data.error);  // Show an error if it exists
            } else {
                const journalHistoryBody = document.getElementById('journal-history-body');
                journalHistoryBody.innerHTML = '';  // Clear previous entries

                // Populate the table with journal entries
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
                    journalHistoryBody.innerHTML += rowHTML;
                });
            }
        })
        .catch(error => console.error('Error fetching journal entries:', error));
}
