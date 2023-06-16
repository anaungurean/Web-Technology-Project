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
            url: '../../BackEnd/index.php',
            method: 'POST',
            data: data,
            dataType: 'json',
             success: function (response) {
    try {
        var parsedResponse = JSON.parse(response);
        // Handle the parsed response here
    } catch (error) {
        console.log("Error parsing JSON response: " + error);
    }
}

        });
    });
});
