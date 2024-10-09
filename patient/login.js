<<<<<<< HEAD
// // Add an event listener to the role selection
// document.getElementById('role').addEventListener('change', function() {
//     var role = this.value;

//     // Redirect based on the role
//     switch (role) {
//         case 'therapist':
//             window.location.href = '../therapist_dashboard.html';
//             break;
//         case 'patient':
//             window.location.href = '../patient_dashboard.html';
//             break;
//         case 'staff':
//             window.location.href = '../staff_dashboard.html';
//             break;
//         case 'auditor':
//             window.location.href = '../auditor_dashboard.html';
//             break;
//         default:
//             alert('Please select a valid role');
//     }
// });
=======
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const role = document.getElementById('role').value;

    // Redirect or alert based on the selected role
    if (role === 'patient') {
        window.location.href = 'patient.html'; // Redirect to patient.html
    } 
    else if (role === 'staff') {
<<<<<<< HEAD
        window.location.href = 'Prof_Staff/staff_portal.php'; // Redirect to staff_portal.php
=======
        window.location.href = 'staff_portal.html'; // Redirect to staff_portal
>>>>>>> 57e604fa2904f1709936fb37f15b45984b068d1e
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

>>>>>>> main
