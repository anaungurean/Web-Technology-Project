document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const plantId = urlParams.get('id');
 
  var jwt = getCookie("User");

    if(jwt===null){
        const confirmed = confirm('The session has expired, you must log in');

        if(confirmed){
            window.location.href='../HTML_Pages/Welcome.html';
        }
    }

  const plantUrl = `http://localhost/TW/BackEnd/getPlant?id=${plantId}`;
  fetch(plantUrl, {
    method: 'GET',
    headers: {
      'Authorization': `Bearer ${jwt}`
    }
  })
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Error:', response.status);
      }
    })
    .then(plantData => {
      const userUrl = `http://localhost/TW/BackEnd/getUser?id=${plantData.id_user}`;
      fetch(userUrl, {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${jwt}`
        }
      })
        .then(response => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error('Error1:', response.status);
          }
        })
        .then(userData => {
        populateFields(plantData, userData);

        const collectorUsername = document.getElementById('collector');
        collectorUsername.textContent = userData.username;
        collectorUsername.addEventListener('click', function() {
            const collectorId = plantData.id_user;

            const profileUrl = `../HTML_Pages/UserProfileNoEdit.html?userId=${collectorId}`;

            window.location.href = profileUrl;
        });
        })
        .catch(error => console.error('Error2:', error));
    })
    .catch(error => console.error('Error3:', error));

  function populateFields(plantData, userData) {
    document.getElementById('common-name').value = plantData.common_name;
    document.getElementById('scientific-name').value = plantData.scientific_name;
    document.getElementById('family').value = plantData.family;
    document.getElementById('genus').value = plantData.genus;
    document.getElementById('species').value = plantData.species;
    document.getElementById('place').value = plantData.place;
    document.getElementById('color-plant').value = plantData.color;
    document.getElementById('collection-name').value = plantData.collection_name;
    document.getElementById('hashtags').value = plantData.hashtags;
    document.getElementById('collector').value = userData.username;
    document.getElementById('date-collection').value = plantData.date_of_collection;

    // const plantImage = document.getElementById('plant-image');
    // plantImage.src = `../../FrontEnd/PlantsImages/${plantData.filename}`;
    // plantImage.alt = plantData.common_name;
     const plantImageContainer = document.querySelector('.logo-image');
      const plantImage = document.createElement('img');
      plantImage.classList.add('plant-image');
      plantImage.id = 'plant-image';
      plantImage.alt = 'Plant Image';

      if (plantData.filename) {
        plantImage.src = `../../FrontEnd/PlantsImages/${plantData.filename}`;
      } else {
        plantImage.src = '../Images/PlantProfileImages/plant.png';
      }

      plantImageContainer.appendChild(plantImage);

  }
  
  function getCookie(name) {
    const cookieValue = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return cookieValue ? cookieValue.pop() : '';
  }
});
