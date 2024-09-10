

document.addEventListener('DOMContentLoaded', () => {
    const saveNotesButton = document.querySelector('#therapistnotes button');
    const additionalNotes = document.querySelector('#additionalNotes');
    
    saveNotesButton.addEventListener('click', () => {
        const notes = additionalNotes.value.trim();
        if (notes) {
            alert('Notes saved successfully!');
            additionalNotes.value = ''; 
        } else {
            alert('Please add some notes before saving.');
        }
    });

    const quickActionButtons = document.querySelectorAll('#actions button');
    quickActionButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const action = event.target.innerText;
            alert(`Action: "${action}" executed successfully!`);
        });
    });
});
