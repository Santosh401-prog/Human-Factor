$(document).ready(function(){
    // Fetch therapist data from review.php using AJAX
    $.ajax({
        url: 'review.php', // Path to your PHP file
        type: 'GET',
        success: function(response) {
            // Populate the table with the response data
            $('#therapist-overview-body').html(response);
        },
        error: function(xhr, status, error) {
            console.log("Error fetching data: " + error);
        }
    });
});

// Go back button functionality
function goBack() {
    window.history.back();
}
