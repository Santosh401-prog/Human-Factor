document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const role = document.getElementById('role').value;

    // Redirect to patient.html after successful login (you can add more conditions for other roles)
    if (role === 'patient') {
        window.location.href = 'patient.html'; // Redirect to patient.html
    } else {
        alert('Only patients are allowed for this demo.');
    }
});
