document.addEventListener('DOMContentLoaded', function() {

    var jwt = getCookie("User");
    var decodedJwt = parseJwt(jwt);
    var id_user = decodedJwt.id;

   const collectionUrl = `http://localhost/TW/BackEnd/getTop?UserId=${id_user}`;
  fetch(collectionUrl, {
    method: 'GET',
    headers: {
      'Authorization': `Bearer ${jwt}`
    }
  })
  .then(function (response) {
        return response.json();
      })
    .then(collectionData => {
      if (Array.isArray(collectionData) && collectionData.length > 0) {

           createPlantElements(collectionData);
           displayMessage('Top 2 most popular plants!');

        } else if (collectionData.Result === 'Not Found') {
          
          displayMessage('We don t have a top :((');

       }
    })
    .catch(error => console.error('Error:', error));

function createPlantElements(collectionData) {
  const plantsContainer = document.getElementById('plantsContainer');
  
  collectionData.forEach(function(plant) {
    const plantDiv = document.createElement('div');
    plantDiv.className = 'plant';

    // Set the onclick event to redirect to the plant profile page
    plantDiv.onclick = function() {
      location.href = `../HTML_Pages/PlantProfilePage.html?id=${plant.id}`;
    };


    const imgElement = document.createElement('img');
    imgElement.src = '../PlantsImages/' + plant.filename;
    imgElement.alt = plant.common_name + ' Image';

    const commonNameElement = document.createElement('p');
    commonNameElement.textContent = plant.common_name;

    plantDiv.appendChild(imgElement);
    plantDiv.appendChild(commonNameElement);

    plantsContainer.appendChild(plantDiv);
  });
}

  function displayMessage(message) {
    const messageElement = document.createElement('p');
    messageElement.textContent = message;
    const plantsContainer = document.getElementById('message');
    plantsContainer.appendChild(messageElement);
  }



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
});
