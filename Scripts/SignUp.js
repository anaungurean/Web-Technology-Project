$(document).ready(function () {
    $('#signup-form').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        var email = $('#email-input').val();
        var username = $('#username-input').val();
        var password = $('#password-input').val();

        // Create the data object to be sent to the API
        var data = {
            email: email,
            username: username,
            password: password
        };

        // Send an AJAX request to the API
        $.ajax({
            url: '../Application/Controllers/SignUpController.php',
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // User registered successfully
                    alert(response.message);
                    // Perform any further actions or redirect the user as needed
                } else {
                    // User registration failed
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.log(error);
            }
        });
    });
});
