$(document).ready(function() {
    // Fetch therapists and patients when the page is ready
    fetchDropdownData('index.php?fetch=therapists', '#therapist');
    fetchDropdownData('index.php?fetch=patients', '#patient');

    // Handle form submission
    $('#selection-form').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var therapist = $('#therapist').val();
        var patient = $('#patient').val();
        var caseType = $('#case-type').val();
        var consultationLength = $('#consultation-length').val();

        // Fetch and display data
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {
                therapist: therapist,
                patient: patient,
                caseType: caseType,
                consultationLength: consultationLength
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

// Function to fetch therapists and patients
function fetchDropdownData(url, selector) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            $(selector).html(response);
        },
        error: function(xhr, status, error) {
            console.log("Error fetching data: " + error);
        }
    });
}

// Go back button function
function goBack() {
    window.history.back();
}
