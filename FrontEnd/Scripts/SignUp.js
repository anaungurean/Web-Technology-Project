document.addEventListener('DOMContentLoaded', function () {
  var signupForm = document.getElementById('signup-form');
  signupForm.addEventListener('submit', function (event) {
    event.preventDefault();

    var email = document.getElementById('email-input').value;
    var username = document.getElementById('username-input').value;
    var password = document.getElementById('password-input').value;
    var confirmPassword = document.getElementById('confirm-password-input').value;

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

    var requestBody = JSON.stringify({
      email: email,
      username: username,
      password: password
    });

    fetch('http://localhost/TW/BackEnd/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: requestBody
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (data.Result === 'User already exists') {
          displayMessage('User already exists.');
        } else if (data.Result === 'User created successfully') {
          displayMessage('User created successfully.');
        } else {
          displayMessage('Unknown response from the server.');
        }
      })
      .catch(function (error) {
        console.error('Error:', error);
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
    var responseMessage = document.getElementById('response-message');
    responseMessage.innerHTML = '<p>' + message + '</p>';
  }
});
