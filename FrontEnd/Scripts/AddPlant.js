document.addEventListener('DOMContentLoaded', function() {

    var jwt = getCookie("User");

    if(jwt===null){
        const confirmed = confirm('The session has expired, you must log in');

        if(confirmed){
            window.location.href='../HTML_Pages/Welcome.html';
        }
    }

    var saveButton = document.getElementById('saveButton');
    saveButton.addEventListener('click', function(event) {
    event.preventDefault();

    var decodedJwt = parseJwt(jwt);
    var id_user = decodedJwt.id;

    var commonNameSelect = document.getElementById("CommonName");
    var commonName = commonNameSelect.options[commonNameSelect.selectedIndex].value;

    var scientificNameSelect = document.getElementById("ScientificName");
    var scientificName = scientificNameSelect.options[scientificNameSelect.selectedIndex].value;

    var familySelect = document.getElementById("Family");
    var family = familySelect.options[familySelect.selectedIndex].value;

    var genusSelect = document.getElementById("Genus");
    var genus = genusSelect.options[genusSelect.selectedIndex].value;

    var speciesSelect = document.getElementById("Species");
    var species = speciesSelect.options[speciesSelect.selectedIndex].value;

    var placeSelect = document.getElementById("Place");
    var place = placeSelect.options[placeSelect.selectedIndex].value;

    var date = document.getElementById("Dateofcollection").value;

    var hashtagSelect = document.getElementById("Hashtags");
    var hashtags = hashtagSelect.options[hashtagSelect.selectedIndex].value;

    var collectionSelect = document.getElementById("CollectionName");
    var collection = collectionSelect.options[collectionSelect.selectedIndex].value;

    var colorSelect = document.getElementById("Coloroftheplant");
    var color = colorSelect.options[colorSelect.selectedIndex].value;

    var fileNameElement = document.getElementById("FileName");
    var photoFileName = fileNameElement.textContent;


    var formData = JSON.stringify({
        id_user: id_user,
        common_name: commonName,
        scientific_name: scientificName,
        family: family,
        genus: genus,
        species: species,
        place: place,
        date_of_collection: date,
        color: color,
        collection_name: collection,
        hashtags: hashtags,
        filename: photoFileName
    });

    fetch('http://localhost/TW/BackEnd/addPlant', {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + jwt,
            'Content-Type': 'application/json'
        },
        body: formData
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
         if (data.Result === 'Plant created successfully') {
            // Fetch the plant data to get the ID
                    fetch(`http://localhost/TW/BackEnd/getPlant?filename=${photoFileName}`, {
              headers: {
                'Authorization': 'Bearer ' + jwt
              }
            })
              .then(response => response.json())
              .then(data => {
                const plantId = data.id;

                window.location.href = `../HTML_Pages/PlantProfilePage.html?id=${plantId}`;
              })
              .catch(error => {
                console.error('Error:', error);
              });
        } else {
            console.log("here");
            displayMessage("Please add all the necessary info and upload the photo!")
        }
    })
    .catch(function (error) {
        console.error('Error:', error);
    });
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
  throw new Error("Cookie '" + name + "' does not exist.");
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
