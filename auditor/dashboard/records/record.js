$(document).ready(function() {
    fetchTherapistData();  // Trigger the function to fetch therapist data on page load
});

function fetchTherapistData() {
    $.ajax({
        url: 'php/therapist_data.php', // Ensure this is the correct path to your PHP file
        method: 'GET',
        dataType: 'json',
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
    var tbody = $('#therapist-overview-body');
    tbody.empty();  // Clear existing data before appending new data

    data.forEach(function(item) {
        var row = '<tr>' +
            '<td>' + item.name + '</td>' +
            '<td>' + item.patients + '</td>' +
            '<td>' + item.cases + '</td>' +
            '<td>' + item.avg_length + '</td>' +
            '</tr>';
        tbody.append(row);  // Append each row to the table body
    });
}
