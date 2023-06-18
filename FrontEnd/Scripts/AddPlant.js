document.addEventListener('DOMContentLoaded', function() {

    var saveButton = document.getElementById('saveButton');
  saveButton.addEventListener('click', function(event) {
    event.preventDefault();
    // Retrieve the JWT from the "User" cookie
    var jwt = getCookie("User");

    // Decode the JWT to extract the user ID
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
        hashtags: hashtags
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
            console.log("merge");

        } else {
            console.log("nu merge");
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