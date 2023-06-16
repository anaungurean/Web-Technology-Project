$(document).ready(function () {
    $('#signup-form').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        var email = $('#email-input').val();
        var username = $('#username-input').val();
        var password = $('#password-input').val();

        // Validate input
        if (!isValidEmail(email)) {
            displayMessage('Invalid email format.');
            return;
        }

        if (isEmpty(username) || isEmpty(password)) {
            displayMessage('Username and password cannot be empty.');
            return;
        }

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
                    console.log(parsedResponse);
                    displayMessage(parsedResponse.message); // Display the response message in the element
                } catch (error) {
                    console.log("Error parsing JSON response: " + error);
                }
            }
        });
    });
});

// Helper function to validate email format
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Helper function to check if a value is empty or null
function isEmpty(value) {
    return value.trim() === '';
}

// Function to display a message in the element with the given ID
function displayMessage(message) {
    $('#response-message').html('<p>' + message + '</p>');
}
