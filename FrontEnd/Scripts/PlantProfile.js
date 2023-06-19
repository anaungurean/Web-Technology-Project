document.addEventListener('DOMContentLoaded', function() {
  // Get the JWT from the cookie
  const jwt = getCookie('User');

  // Fetch the plant data
  const plantUrl = 'http://localhost/TW/BackEnd/getPlant?id=1';
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
      // Use the id_user from plantData to fetch user data
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
          // Populate fields with both plant and user data
          populateFields(plantData, userData);
        })
        .catch(error => console.error('Error2:', error));
    })
    .catch(error => console.error('Error3:', error));

  // Function to populate the fields with the fetched data
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
  }

  // Function to get the value of a cookie by name
  function getCookie(name) {
    const cookieValue = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return cookieValue ? cookieValue.pop() : '';
  }
});
