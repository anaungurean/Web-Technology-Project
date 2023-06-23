document.addEventListener('DOMContentLoaded', function() {
  // Retrieve the query parameter
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const words = JSON.parse(decodeURIComponent(urlParams.get('words')));

  // Use the 'words' array as needed
   var jwt = getCookie('User');
    var decodedJwt = parseJwt(jwt);
    var id_user = decodedJwt.id;

    const collectionUrl = 'http://localhost/TW/BackEnd/getCollections';
    fetch(collectionUrl, {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${jwt}`
      }
    })
      .then(function(response) {
        return response.json();
      })
      .then(function(collectionData) {
        if (Array.isArray(collectionData) && collectionData.length > 0) {
          console.log(collectionData);
          const matchingPlants = getMatchingPlants(collectionData, words);

          if (matchingPlants.length > 0) {
            createPlantElements(matchingPlants);
          } else {
            alert('No plants found based on the selected criteria.');
            createPlantElements(collectionData);

          }
        console.log("cautate:")
          console.log(matchingPlants);
        } else if (collectionData.Result === 'Not Found') {
          alert('There are no plants in our garden :(');
        }
      })
      .catch(function(error) {
        console.error('Error:', error);
      });

    // Example: Log the keyword and words array to the console
    console.log('Words:', words);
});

  function getMatchingPlants(collectionData, criteria) {
    return collectionData.filter(plant => matchesCriteria(plant, criteria));
  }


function matchesCriteria(plant, criteria) {
    return (
      (  criteria.includes(plant.common_name)) ||
      (  criteria.includes(plant.scientific_name)) ||
      (  criteria.includes(plant.family)) ||
      (  criteria.includes(plant.genus)) ||
      (  criteria.includes(plant.species)) ||
      (  criteria.includes(plant.place)) ||
      (  criteria.includes(plant.collection_name)) ||
      (  criteria.includes(plant.color))
    );
  }

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

function getCookie(name) {
  var cookieArr = document.cookie.split(';');
  for (var i = 0; i < cookieArr.length; i++) {
    var cookiePair = cookieArr[i].split('=');
    if (name === cookiePair[0].trim()) {
      return decodeURIComponent(cookiePair[1]);
    }
  }
  return null;
}

function parseJwt(token) {
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
  var jsonPayload = decodeURIComponent(
    atob(base64)
      .split('')
      .map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      })
      .join('')
  );

  return JSON.parse(jsonPayload);
}
















