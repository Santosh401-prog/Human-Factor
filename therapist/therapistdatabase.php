<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}

// Connect to database
$conn = new mysqli('localhost', 'username', 'password', 'staff_portal');

// Check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patients
$sql = "SELECT first_name, last_name, age, height, weight, gender FROM patients";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Data</title>
    <link rel="stylesheet" href="therapist.css">
    <style>
        /* Table and Modal Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .view-btn, .add-note-btn {
            background-color: #2196F3;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .view-btn:hover, .add-note-btn:hover {
            background-color: #1976D2;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            overflow: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Form Styles */
        .modal textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        .modal button {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>Patient Summary</h1>
</header>

<div class="sidebar">
    <ul>
        <li><a href="therapistdashboard.html">Dashboard</a></li>
        <li><a href="patient-data.html">Patient Summary</a></li>
        <li><a href="group-management.html">Group Management</a></li>
    </ul>
</div>

<div class="main-content">
    <main>
        <section>
            <h2>Patient Data</h2>
            <input type="text" id="search" placeholder="Search by name" onkeyup="filterPatients()" />
            <table id="patient-table">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Patient rows will be added dynamically here -->
                </tbody>
            </table>
        </section>

        <!-- Modal for viewing patient details -->
        <div id="patient-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2 id="modal-patient-name"></h2>
                <p><strong>Age:</strong> <span id="modal-patient-age"></span></p>
                <p><strong>Mood:</strong> <span id="modal-patient-mood"></span></p>
                <p><strong>Sleep Duration:</strong> <span id="modal-patient-sleep"></span> hours</p>
                <p><strong>Exercise:</strong> <span id="modal-patient-exercise"></span></p>
                <p><strong>Other Activities:</strong> <span id="modal-patient-activities"></span></p>
            </div>
        </div>

        <!-- Modal for adding patient notes -->
        <div id="note-modal" class="modal">
            <div class="modal-content">
                <span class="close-note-btn">&times;</span>
                <h2>Add Note for <span id="note-patient-name"></span></h2>
                <textarea id="patient-note" placeholder="Enter note"></textarea>
                <button id="save-note-btn">Save Note</button>
            </div>
        </div>
    </main>
</div>

<script>

    
    // Function to fetch patient data from the server using AJAX
    function fetchPatients() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch-patients.php', true);
        xhr.onload = function() {
            if (this.status === 200) {
                const patients = JSON.parse(this.responseText);
                populatePatientTable(patients);
            }
        };
        xhr.send();
    }

    // Function to populate the patient table dynamically
    function populatePatientTable(patients) {
        const patientTableBody = document.querySelector('#patient-table tbody');
        patientTableBody.innerHTML = ''; // Clear previous rows

        patients.forEach(patient => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${patient.name}</td>
                <td>${patient.age}</td>
                <td>
                    <button class="view-btn" data-id="${patient.id}">View</button>
                    <button class="add-note-btn" data-id="${patient.id}">Add Note</button>
                </td>
            `;
            patientTableBody.appendChild(row);
        });
    }

    // Function to filter patients based on the search input
    function filterPatients() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('#patient-table tbody tr');
        rows.forEach(row => {
            const name = row.cells[0].textContent.toLowerCase();
            if (name.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Call fetchPatients when the page loads
    document.addEventListener('DOMContentLoaded', fetchPatients);
</script>

</body>
</html>

<?php
$conn->close();
?>
