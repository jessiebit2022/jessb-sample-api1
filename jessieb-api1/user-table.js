jQuery(document).ready(function($) {

    // Handle clicks on the user details links
    $('.user-details-link').click(function(e) {
        e.preventDefault();
        var userId = $(this).data('user-id');
        // Fetch user details
        $.ajax({
            url: user_table_data.user_details_endpoint + userId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Show the user details
                $('#user-details').html(data.name + '<br>' + data.email + '<br>' + data.address.city).fadeIn();
            },
            error: function(xhr, status, error) {
                console.log('An error occurred: ' + error);
            }
        });
    });
    
    });
    