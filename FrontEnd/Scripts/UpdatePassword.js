document.addEventListener('DOMContentLoaded', function() {
  const submitButton = document.getElementById('submit-button');
  const usernameInput = document.getElementById('username');
  const passwordInput = document.getElementById('password');

  submitButton.addEventListener('click', function(event) {
    event.preventDefault();
    updatePassword();
  });
});

// Function to update the password
function updatePassword() {
  const url = 'http://localhost/TW/BackEnd/updatePassword';
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  const data = {
    username: username,
    password: password
  };
  console.log(data);
  fetch(url, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  })
    .then(response => {
      if (response.ok) {
        displayMessage('Password updated successfully');
      } else if (response.status === 404) {
         displayMessage('Username not found');
      } else {
        // An error occurred while updating the password
        displayMessage('An error occurred while updating the password');
      }
    })
    .catch(error => {
      console.error('An error occurred:', error);
    });
}

function displayMessage(message) {
  const messageElement = document.createElement('p');
  messageElement.textContent = message;
  const messageContainer = document.getElementById('message');
  
  while (messageContainer.firstChild) {
    messageContainer.firstChild.remove();
  }
  
  messageContainer.appendChild(messageElement);
}


