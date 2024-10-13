$(document).ready(function() {
    fetchPatientData();
});

function fetchPatientData() {
    $.ajax({
        url: 'path/to/php/patient_data.php', // Update the path as necessary
        method: 'GET',
        data: { action: 'fetch' }, // Specify the action for PHP
        dataType: 'json',
        success: function(data) {
            populateTable(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error fetching data: ' + textStatus);
        }
    });
}

function populateTable(data) {
    var tbody = $('#therapist-overview-body');
    tbody.empty(); // Clear existing data

    data.forEach(function(item) {
        var row = '<tr>' +
            '<td>' + item.name + '</td>' +
            '<td>' + item.patients + '</td>' +
            '<td>' + item.cases + '</td>' +
            '<td>' + item.avg_length + '</td>' +
            '</tr>';
        tbody.append(row);
    });
}
