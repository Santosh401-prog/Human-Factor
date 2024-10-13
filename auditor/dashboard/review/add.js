$(document).ready(function() {
    fetchTherapistData();  // Changed to fetch therapist data
});

function fetchTherapistData() {
    $.ajax({
        url: 'php/therapist_data.php', // Path to your PHP file for fetching therapist data
        method: 'GET',
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
