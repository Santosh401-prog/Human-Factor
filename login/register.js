document.addEventListener('DOMContentLoaded', function() {
    // Form validation logic
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        const username = document.getElementById('newUsername').value.trim();
        const password = document.getElementById('newPassword').value;
        const role = document.getElementById('newRole').value;

        // Check if all fields are filled
        if (!username || !password || !role) {
            alert('Please fill in all fields.');
            event.preventDefault(); // Prevent form submission
            return;
        }




        // Ensure a valid role is selected
        if (role === "") {
            alert('Please select a valid role.');
            event.preventDefault(); // Prevent form submission
            return;
        }
    });

    // Success/Error message handling
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = document.getElementById('error-message');
    const successMessage = document.getElementById('success-message');

    if (urlParams.has('success')) {
        successMessage.style.display = 'block';
    }
    if (urlParams.has('error')) {
        const errorType = urlParams.get('error');
        switch (errorType) {
            case 'username_exists':
                errorMessage.innerText = 'Error: Username already exists. Please choose another.';
                break;
            case 'patient_not_found':
                errorMessage.innerText = 'Error: No patient found with that name. Please use the name created by the staff.';
                break;
            default:
                errorMessage.innerText = 'Error: Something went wrong. Please try again.';
        }
        errorMessage.style.display = 'block';
    }
});
