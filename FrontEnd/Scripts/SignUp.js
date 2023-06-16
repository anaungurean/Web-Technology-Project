$(document).ready(function () {
  $('#signup-form').submit(function (event) {
    event.preventDefault();  

    var email = $('#email-input').val();
    var username = $('#username-input').val();
    var password = $('#password-input').val();
    var confirmPassword = $('#confirm-password-input').val();
  
 
    if (!isValidEmail(email)) {
      displayMessage('Invalid email format.');
      return;
    }

    if (isEmpty(username) || isEmpty(password)) {
      displayMessage('Username and password cannot be empty.');
      return;
    }

    if (password !== confirmPassword) {
      displayMessage('Password and confirm password do not match.');
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
      success: function(response) {
     
        if (response && response.success) {
           window.location.href = '..//HTML_Pages/SignIn.html';
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



function isValidEmail(email) {
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function isEmpty(value) {
  return value.trim() === '';
}

function displayMessage(message) {
  $('#response-message').html('<p>' + message + '</p>');
}
