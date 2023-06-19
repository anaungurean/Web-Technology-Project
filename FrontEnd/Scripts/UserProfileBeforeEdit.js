document.addEventListener('DOMContentLoaded', function() {
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const descriereInput = document.getElementById('descriere');
    const hobbyInput = document.getElementById('hobby');
    const interesPlantInput = document.getElementById('interes_plant');
    const firstnameInput = document.getElementById('firstname');
    const lastnameInput = document.getElementById('lastname');
    const phoneInput = document.getElementById('phone');
    const adresaInput = document.getElementById('adresa');
    const count = document.getElementById('count');

    const editProfileButton = document.querySelector('.button2');
  
    var jwt = getCookie("User");
    var decodedJwt = parseJwt(jwt);
    var id_user = decodedJwt.id;
  
    fetch(`http://localhost/TW/BackEnd/users/${id_user}`)
      .then(response => response.json())
      .then(data => {

        descriereInput.value = data.descriere;
        hobbyInput.value = data.hobby;
        interesPlantInput.value = data.interes_plant;
        usernameInput.value = data.username;
        emailInput.value = data.email;
        passwordInput.value = data.password_hash;
        firstnameInput.value = data.firstname;
        lastnameInput.value = data.lastname;
        phoneInput.value = data.phone;
        adresaInput.value = data.adresa;
        count.value = data.count;

      })
      .catch(error => {
        console.error('Error:', error);
      });
  

    editProfileButton.addEventListener('click', function() {
    const inputFields = document.querySelectorAll('.form-control');
    const saveInfoButton = document.querySelector('.button2');

    if (editProfileButton.textContent === 'Edit Profile') {
    inputFields.forEach(function(input) {
      if (input.id !== 'username' && input.id !== 'email' && input.id !== 'password'&& input.id !== 'count' ) {
        input.disabled = false;
        input.placeholder = 'You can edit this field';
      }
    });

    saveInfoButton.textContent = 'Save Information';
    } else {
 inputFields.forEach(function(input) {
        if (input.id !== 'username' && input.id !== 'email' && input.id !== 'password') {
            input.disabled = true;
            input.placeholder = '';
        }
        });

        
        const updatedUsername = usernameInput.value;
        const updatedEmail = emailInput.value;
        const updatedPassword = passwordInput.value;
        const updatedDescriere = descriereInput.value;
        const updatedHobby = hobbyInput.value;
        const updatedInteresPlant = interesPlantInput.value;
        const updatedFirstname = firstnameInput.value;
        const updatedLastname = lastnameInput.value;
        const updatedPhone = phoneInput.value;
        const updatedAdresa = adresaInput.value;


        const updatedUser = JSON.stringify({
            id: id_user,
            username: updatedUsername,
            email: updatedEmail,
            password: updatedPassword,
            descriere: updatedDescriere,
            hobby: updatedHobby,
            interes_plant: updatedInteresPlant,
            firstname: updatedFirstname,
            lastname: updatedLastname,
            phone: updatedPhone,
            adresa: updatedAdresa
        });


        fetch(`http://localhost/TW/BackEnd/profile/${id_user}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: updatedUser
        })
        .then(function (response) {
            return response.json();
          })
          .then(function (data) {
            if (data.message === 'User information updated successfully') {
                console.log("merge");
    
            } else {
                console.log(data);
            }
          })
          .catch(function (error) {
            console.error('Error:', error);
            console.log(updatedUser);
          });

        editProfileButton.textContent = 'Edit Profile';
    }
});
  
  });


function getCookie(name) {
    var cookieArr = document.cookie.split(";");
    for (var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        if (name === cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
}

function parseJwt(token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}

function displayMessage(message) {
    var responseMessage = document.getElementById('response-message');
    responseMessage.innerHTML = '<p>' + message + '</p>';
}

