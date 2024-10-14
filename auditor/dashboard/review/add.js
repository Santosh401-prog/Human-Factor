$(document).ready(function() {
    // Populate the dropdowns with therapists and patients
    populateDropdowns();

    // Handle form submission
    $('#selection-form').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        submitAudit(); // Call the submitAudit function
    });
});

// Function to populate the therapist and patient dropdowns
function populateDropdowns() {
    // Fetch therapists and patients
    fetchDropdownData('therapists', '#therapist'); // Populate therapist dropdown
    fetchDropdownData('patients', '#patient');     // Populate patient dropdown
}


// Generic function to fetch data from the server and populate a dropdown
function fetchDropdownData(type, dropdownId) {
    $.ajax({
        url: 'http://localhost/human-Factor/auditor/dashboard/review/get_users.php', // Ensure this is the correct path to your PHP file
        method: 'GET',
        data: { fetch: type }, // Pass 'therapists' or 'patients' as a parameter
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                alert(data.error);
            } else {
                // Populate the dropdown with the returned data
                $.each(data[type], function(index, user) {
                    $(dropdownId).append($('<option>', {
                        value: user.id,
                        text: user.username
                    }));
                });
            }
        },
        error: function() {
            console.error('Error fetching ' + type + ' data.');
        }
    });
}

// Function to submit the form
function submitAudit() {
    var formData = $('#selection-form').serialize();

    $.ajax({
        url: 'http://localhost/human-Factor/auditor/dashboard/review/get_users.php?fetch=therapistsget_users.php', // Ensure this is the correct path to your PHP file
        method: 'POST',
        data: formData,
        success: function(response) {
            alert(response); // Show success message
            $('#results-section').show(); // Show the results section
        },
        error: function() {
            alert('Error submitting the form.');
        }
    });
}
