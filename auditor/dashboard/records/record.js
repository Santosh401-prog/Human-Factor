$(document).ready(function() {
    fetchPatientData();  // Trigger the function to fetch patient data on page load
});

function fetchPatientData() {
    $.ajax({
        url: 'php/review.php',  // Ensure the correct path to your PHP file
        method: 'GET',
        dataType: 'json',       // Expect JSON response
        success: function(data) {
            console.log("Data received:", data);  // Debugging statement to view the fetched data
            populateTable(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error fetching data:', textStatus, errorThrown);  // Logs any errors encountered during the request
        }
    });
}

function populateTable(data) {
    var tbody = $('#patientRecordsTableBody');
    tbody.empty();  // Clear existing data before appending new data

    // Loop through the data and create table rows
    data.forEach(function(item) {
        var row = '<tr>' +
            '<td>' + item.patient_id + '</td>' +
            '<td>' + item.last_consultation + '</td>' +
            '<td>' + item.visits + '</td>' +
            '<td>' + item.assigned_therapist + '</td>' +
            '<td>' + item.status + '</td>' +
            '</tr>';
        tbody.append(row);  // Append each row to the table body
    });
}
