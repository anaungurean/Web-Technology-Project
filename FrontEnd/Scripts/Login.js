$(document).ready(function() {
    $('#login-form').submit(function(event) {
        event.preventDefault();

        var username = $('#username-input').val();
        var password = $('#password-input').val();

        if (isEmpty(username) || isEmpty(password)) {
            displayMessage('Username and password cannot be empty.');
            return;
        }

        // Create the data object to be sent to the API
        var data = {
            username: username,
            password: password
        };

        // Send an AJAX request to the API
        $.ajax({
            url: '../../BackEnd/index2.php',
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    window.location.href = '..//HTML_Pages/HomePage.html';
                } else if (response && response.message) {
                    displayMessage(response.message);
                } else {
                    displayMessage('An unexpected error occurred.');
                }
            },
            error: function(xhr, status, error) {
                displayMessage('An error occurred: ' + error);
            }
        });
    });
});


function isEmpty(value) {
    return value.trim() === '';
  }

function displayMessage(message) {
    $('#response-message').html('<p>' + message + '</p>');
  }
  

  
