document.addEventListener('DOMContentLoaded', function() {

    var jwt = getCookie("User");
    var decodedJwt = parseJwt(jwt);
    var id_user = decodedJwt.id;

   const collectionUrl = `http://localhost/TW/BackEnd/getCollections`;
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
          console.log(collectionData)
          createPlantElements(collectionData);
        } else if (collectionData.Result === 'Not Found') {
       }
    })
    .catch(error => console.error('Error:', error));

function createPlantElements(collectionData) {
  const rightSectionContainer = document.querySelector('.right-section');

  collectionData.forEach(function(plant) {
    const plantDiv = document.createElement('div');
    plantDiv.className = 'plant';

    plantDiv.onclick = function() {
      location.href = `../HTML_Pages/PlantProfileNoEdit.html?id=${plant.id}`;
    };

    const imageContainerDiv = document.createElement('div');

    const imgElement = document.createElement('img');
    imgElement.className = 'image';
    imgElement.src = '../PlantsImages/' + plant.filename;
    imgElement.alt = 'image';

    const anchorElement = document.createElement('a');
    anchorElement.textContent = plant.common_name;

    plantDiv.appendChild(imgElement);
    plantDiv.appendChild(imageContainerDiv);
    plantDiv.appendChild(anchorElement);
    rightSectionContainer.appendChild(plantDiv);
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
