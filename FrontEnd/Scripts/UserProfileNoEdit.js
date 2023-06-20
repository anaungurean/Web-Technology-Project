document.addEventListener('DOMContentLoaded', function() {
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const descriereInput = document.getElementById('descriere');
    const hobbyInput = document.getElementById('hobby');
    const interesPlantInput = document.getElementById('interes_plant');
    const firstnameInput = document.getElementById('firstname');
    const lastnameInput = document.getElementById('lastname');
    const phoneInput = document.getElementById('phone');
    const adresaInput = document.getElementById('adresa');
    const count = document.getElementById('count');

    const urlParams = new URLSearchParams(window.location.search);
    const id_user = urlParams.get('userId');


    // console.log(id_user);

    // Get the JWT from the cookie
    const jwt = getCookie('User');
  
    fetch(`http://localhost/TW/BackEnd/users?id=${id_user}` , {
        headers: {
            'Authorization': `Bearer ${jwt}`
        }
    })
      .then(response => response.json())
      .then(data => {

        descriereInput.value = data.descriere;
        hobbyInput.value = data.hobby;
        interesPlantInput.value = data.interes_plant;
        usernameInput.value = data.username;
        emailInput.value = data.email;
        firstnameInput.value = data.firstname;
        lastnameInput.value = data.lastname;
        phoneInput.value = data.phone;
        adresaInput.value = data.adresa;
        count.value = data.count;
      })
      .catch(error => {
        console.error('Error:', error);
      });

    // Function to get the value of a cookie by name
    function getCookie(name) {
      const cookieValue = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
      return cookieValue ? cookieValue.pop() : '';
    }
    }
);



