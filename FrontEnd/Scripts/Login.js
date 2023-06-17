document.addEventListener('DOMContentLoaded', function() {
  var loginForm = document.getElementById('login-form');
  loginForm.addEventListener('submit', function(event) {
    event.preventDefault();

    var username = document.getElementById('username-input').value;
    var password = document.getElementById('password-input').value;

    if (isEmpty(username) || isEmpty(password)) {
      displayMessage('Username and password cannot be empty.');
      return;
    }

   var requestBody = JSON.stringify({
       username: username,
      password: password
    });

 
    fetch('http://localhost/TW/BackEnd/auth', {
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
        if (data.Result === 'Invalid info.') {
          displayMessage('The username or the password is not correct.');
        } else   {
             window.location.href = '../HTML_Pages/HomePage.html';
         }  
      })
      .catch(function (error) {
        console.error('Error:', error);
      });
      
  });
     
});

function isEmpty(value) {
  return value.trim() === '';
}

function displayMessage(message) {
  var responseMessage = document.getElementById('response-message');
  responseMessage.innerHTML = '<p>' + message + '</p>';
}
