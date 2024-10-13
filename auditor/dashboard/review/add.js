$(document).ready(function(){
    // Initialize form and fetch dropdown data
    fetchDropdownData('getTherapists.php', '#therapist');
    fetchDropdownData('getPatients.php', '#patient');

    // Handle form submission
    $('#selection-form').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var therapist = $('#therapist').val();
        var patient = $('#patient').val();
        var caseType = $('#case-type').val();
        var consultationLength = $('#consultation-length').val(); // Get consultation length value

        // Fetch and display data based on selected values
        $.ajax({
            url: 'fetchData.php', // PHP file to fetch detailed data
            type: 'POST',
            data: {
                therapist: therapist,
                patient: patient,
                caseType: caseType,
                consultationLength: consultationLength // Include in AJAX data
            },
            success: function(response) {
                $('#results-body').html(response);
                $('#results-section').show(); // Show results section
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    });
});

function fetchDropdownData(file, selector) {
    $.ajax({
        url: file,
        type: 'GET',
        success: function(response) {
            $(selector).html(response);
        },
        error: function(xhr, status, error) {
            console.log("Error fetching data: " + error);
        }
    });
}

function goBack() {
    window.history.back();
}
