document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const role = document.getElementById('role').value;

    // Redirect or alert based on the selected role
    if (role === 'patient') {
        window.location.href = 'patient.html'; // Redirect to patient.html
    } 
    else if (role === 'staff') {
        window.location.href = 'staff_portal.php'; // Redirect to staff_portal.php
    } 
    else if (role === 'therapist') {
        window.location.href = 'therapistdashboard.html'; // Redirect to therapist portal
    } 
    else if (role === 'auditor') {
        window.location.href = 'auditor.html'; // Redirect to auditor portal
    } 
    // Separate alerts based on roles
    else if (role !== 'patient') {
        alert('Only patients are allowed for this demo.');
    }
    else if (role !== 'staff') {
        alert('Only professional staff are allowed for this demo.');
    }
    else if (role !== 'therapist') {
        alert('Only therapists are allowed for this demo.');
    }
    else if (role !== 'auditor') {
        alert('Only auditors are allowed for this demo.');
    }
});

