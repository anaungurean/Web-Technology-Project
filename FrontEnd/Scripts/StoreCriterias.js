document.addEventListener('DOMContentLoaded', function() {
  const commonNameList = document.getElementById('common-name');
  const scientificNameList = document.getElementById('scientific-name');
  const plantFamilyList = document.getElementById('plant-family');
  const genusList = document.getElementById('genus');
  const speciesList = document.getElementById('species');
  const placeList = document.getElementById('place');
  const plantCollectionList = document.getElementById('plant-collection');
  const plantColorList = document.getElementById('plant-color');

  const findButton = document.getElementById('find-button');

  findButton.addEventListener('click', function() {
    fetchData();
  });

  function storeCriteria() {
    const criteria = {
      commonName: getSelectedValues(commonNameList),
      scientificName: getSelectedValues(scientificNameList),
      plantFamily: getSelectedValues(plantFamilyList),
      genus: getSelectedValues(genusList),
      species: getSelectedValues(speciesList),
      place: getSelectedValues(placeList),
      period: {
        startDate: document.getElementById('start-date').value,
        endDate: document.getElementById('end-date').value
      },
      plantCollection: getSelectedValues(plantCollectionList),
      plantColor: getSelectedValues(plantColorList)
    };
    return criteria;
  }

  function getSelectedValues(list) {
    const selectedValues = [];
    const checkboxes = list.querySelectorAll('input[type="checkbox"]:checked');
    checkboxes.forEach(function(checkbox) {
      selectedValues.push(checkbox.value);
    });
    return selectedValues;
  }

  function fetchData() {
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
      .then(function(response) {
        return response.json();
      })
      .then(collectionData => {
        if (Array.isArray(collectionData) && collectionData.length > 0) {
          const criteria = storeCriteria();
          const matchingPlants = getMatchingPlants(collectionData, criteria);

          if (matchingPlants.length > 0) {
            createPlantElements(matchingPlants);
          } else {
            alert('No plants found based on the selected criteria.');
          }
         } else if (collectionData.Result === 'Not Found') {
             alert('There is no plants in our garden :(');
        }
      })
      .catch(error => console.error('Error:', error));
  }

  function createPlantElements(collectionData) {
    const rightSectionContainer = document.querySelector('.right-section');
    rightSectionContainer.innerHTML = ''; 

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
      }
    );
  }

  function getMatchingPlants(collectionData, criteria) {
    return collectionData.filter(plant => matchesCriteria(plant, criteria));
  }

  function matchesCriteria(plant, criteria) {
    return (
      (criteria.commonName.length === 0 || criteria.commonName.includes(plant.common_name)) &&
      (criteria.scientificName.length === 0 || criteria.scientificName.includes(plant.scientific_name)) &&
      (criteria.plantFamily.length === 0 || criteria.plantFamily.includes(plant.family)) &&
      (criteria.genus.length === 0 || criteria.genus.includes(plant.genus)) &&
      (criteria.species.length === 0 || criteria.species.includes(plant.species)) &&
      (criteria.place.length === 0 || criteria.place.includes(plant.place)) &&
      (criteria.period.startDate === '' || criteria.period.endDate === '' || checkPeriod(plant, criteria.period)) &&
      (criteria.plantCollection.length === 0 || criteria.plantCollection.includes(plant.collection_name)) &&
      (criteria.plantColor.length === 0 || criteria.plantColor.includes(plant.color))
    );
  }

  function checkPeriod(plant, period) {
    const startDate = new Date(period.startDate);
    const endDate = new Date(period.endDate);
    const plantDate = new Date(plant.date_of_collection);

    return plantDate >= startDate && plantDate <= endDate;
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
});
