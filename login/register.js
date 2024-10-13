document.getElementById('registerForm').addEventListener('submit', function(event) {
    const username = document.getElementById('newUsername').value;
    const password = document.getElementById('newPassword').value;
    const role = document.getElementById('newRole').value;

    if (!username || !password || !role) {
        alert('Please fill in all fields.');
        event.preventDefault();
    }
});
