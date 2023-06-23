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
          setupEditButton(plantData, userData);
        })
        .catch(error => console.error('Error2:', error));
    })
    .catch(error => console.error('Error3:', error));

  function populateFields(plantData, userData) {
    document.getElementById('common-name').textContent = plantData.common_name;
    document.getElementById('scientific-name').textContent = plantData.scientific_name;
    document.getElementById('family').textContent = plantData.family;
    document.getElementById('genus').textContent = plantData.genus;
    document.getElementById('species').textContent = plantData.species;
    document.getElementById('place').textContent = plantData.place;
    document.getElementById('color-plant').textContent = plantData.color;
    document.getElementById('collection-name').textContent = plantData.collection_name;
    document.getElementById('hashtags').textContent = plantData.hashtags;
    document.getElementById('collector').textContent = userData.username;
    document.getElementById('date-collection').textContent = plantData.date_of_collection;

    const plantImage = document.getElementById('plant-image');
    plantImage.src = `../../FrontEnd/PlantsImages/${plantData.filename}`;
    plantImage.alt = plantData.common_name;
  }

  function setupEditButton(plantData, userData) {
    const editButton = document.getElementById('edit-button');

    editButton.addEventListener('click', function() {
      document.getElementById('common-name').innerHTML = createSelectElement('common-name', plantData.common_name);
      document.getElementById('scientific-name').innerHTML = createSelectElement('scientific-name', plantData.scientific_name);
      document.getElementById('family').innerHTML = createSelectElement('family', plantData.family);
      document.getElementById('genus').innerHTML = createSelectElement('genus', plantData.genus);
      document.getElementById('species').innerHTML = createSelectElement('species', plantData.species);
      document.getElementById('place').innerHTML = createSelectElement('place', plantData.place);
      document.getElementById('color-plant').innerHTML = createSelectElement('color-plant', plantData.color);
      document.getElementById('collection-name').innerHTML = createSelectElement('collection-name', plantData.collection_name);
      document.getElementById('hashtags').innerHTML = createSelectElement('hashtags', plantData.hashtags);
      document.getElementById('date-collection').innerHTML = createDatePicker('date-collection', plantData.date_of_collection);

      
      const commonNameSelect = document.getElementById('common-name-select');
      addOptionsToSelect(commonNameSelect, commonNameOptions);

      const scientificNameSelect = document.getElementById('scientific-name-select');
      addOptionsToSelect(scientificNameSelect, scientificNameOptions);

      const familySelect = document.getElementById('family-select');
      addOptionsToSelect(familySelect, familyOptions);

      const genusSelect = document.getElementById('genus-select');
      addOptionsToSelect(genusSelect, genusOptions);

      const speciesSelect = document.getElementById('species-select');
      addOptionsToSelect(speciesSelect, speciesOptions);

      const placeSelect = document.getElementById('place-select');
      addOptionsToSelect(placeSelect, placeOptions);

      const colorPlantSelect = document.getElementById('color-plant-select');
      addOptionsToSelect(colorPlantSelect, colorPlantOptions);

      const collectionNameSelect = document.getElementById('collection-name-select');
      addOptionsToSelect(collectionNameSelect, collectionNameOptions);

      const hashtagsSelect = document.getElementById('hashtags-select');
      addOptionsToSelect(hashtagsSelect, hashtagsOptions);

      editButton.textContent = 'Save Information';

      editButton.removeEventListener('click', arguments.callee);
      editButton.addEventListener('click', function() {
      saveInformation(plantData.id);
      });
    });

    function saveInformation(plantId) {
      
      const commonName = document.getElementById('common-name-select').value;
      const scientificName = document.getElementById('scientific-name-select').value;
      const family = document.getElementById('family-select').value;
      const genus = document.getElementById('genus-select').value;
      const species = document.getElementById('species-select').value;
      const place = document.getElementById('place-select').value;
      const colorPlant = document.getElementById('color-plant-select').value;
      const collectionName = document.getElementById('collection-name-select').value;
      const hashtags = document.getElementById('hashtags-select').value;
      const dateCollection = document.getElementById('date-collection-select').value;

      const jsonData = {
        common_name: commonName,
        scientific_name: scientificName,
        family: family,
        genus: genus,
        species: species,
        place: place,
        color: colorPlant,
        collection_name: collectionName,
        hashtags: hashtags,
        date_of_collection: dateCollection
      };

      const saveUrl = `http://localhost/TW/BackEnd/updatePlant?id=${plantId}`;
      fetch(saveUrl, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${jwt}`
        },
        body: JSON.stringify(jsonData)
      })
        .then(response => {
          if (response.ok) {
            console.log('Information saved successfully.');
            document.location.reload();
          } else {
            throw new Error('Error:', response.status);
          }
        })
        .catch(error => console.error('Error:', error));
        
      editButton.textContent = 'Edit Plant';
      editButton.removeEventListener('click', saveInformation);
      editButton.addEventListener('click', function() {
        document.location.reload();
      });
    }
  }

  function createSelectElement(id, value) {
    return `<select id="${id}-select"><option value="${value}">${value}</option></select>`;
  }

  function createDatePicker(id, value) {
    return `<input type="date" id="${id}-select" value="${value}">`;
  }

  function addOptionsToSelect(selectElement, options) {
    for (let i = 0; i < options.length; i++) {
      const option = document.createElement('option');
      option.value = options[i];
      option.textContent = options[i];
      selectElement.appendChild(option);
    }
  }

    const commonNameOptions = ['Amaryllis', 'Begonia', 'Bluebell', 'Carnation', 'Chrysanthemum', 'Cosmos', 'Daffodil', 'Dahlia', 'Daisy', 'Dandelion', 'Forget-me-not', 'Foxglove', 'Fuchsia', 'Geranium', 'Gladiolus', 'Honeysuckle', 'Hollyhock', 'Hyacinth', 'Iris', 'Jasmine', 'Jonquil', 'Lavender', 'Lily', 'Lupine', 'Magnolia', 'Marigold', 'Narcissus', 'Orchid', 'Pansy', 'Petunia', 'Poppy', 'Primrose', 'Rhododendron', 'Rose', 'Snapdragon', 'Sunflower', 'Sweet pea', 'Tulip', 'Violet', 'Yarrow', 'Zinnia'];
    const scientificNameOptions = ['Achillea', 'Alcea', 'Amaryllis', 'Antirrhinum', 'Bellis perennis', 'Begonia', 'Chrysanthemum', 'Cosmos bipinnatus', 'Daffodil', 'Dahlia', 'Daisy', 'Digitalis', 'Dianthus caryophyllus', 'Fuchsia', 'Gladiolus', 'Helianthus annuus', 'Hippeastrum', 'Hyacinthus', 'Hyacinthoides non-scripta', 'Iris', 'Jasminum', 'Lathyrus odoratus', 'Lavandula', 'Lilium', 'Lonicera', 'Magnolia', 'Marigold', 'Myosotis', 'Narcissus', 'Narcissus jonquilla', 'Orchidaceae', 'Paeonia', 'Papaver', 'Pelargonium', 'Primula', 'Rhododendron', 'Rosa', 'Tagetes', 'Taraxacum', 'Tulipa', 'Viola', 'Viola tricolor', 'Zinnia'];
    const familyOptions = ['Asteraceae', 'Apiaceae', 'Asparagaceae', 'Amaryllidaceae', 'Begoniaceae', 'Brassicaceae', 'Caprifoliaceae', 'Caryophyllaceae', 'Chrysanthemum', 'Dahlia', 'Ericaceae', 'Fabaceae', 'Geraniaceae', 'Hyacinthaceae', 'Iridaceae', 'Lamiaceae', 'Liliaceae', 'Malvaceae', 'Onagraceae', 'Orchidaceae', 'Oleaceae', 'Paeoniaceae', 'Papaveraceae', 'Plantaginaceae', 'Primulaceae', 'Ranunculaceae', 'Rosaceae', 'Scrophulariaceae', 'Solanaceae', 'Violaceae'];
    const genusOptions = ['Achillea', 'Alcea', 'Amaryllis', 'Begonia', 'Bellis', 'Calendula', 'Campanula', 'Chrysanthemum', 'Cosmos', 'Dahlia', 'Dianthus', 'Digitalis', 'Fuchsia', 'Gladiolus', 'Hyacinthus', 'Iris', 'Jasminum', 'Lavandula', 'Lilium', 'Lonicera', 'Lupinus', 'Magnolia', 'Myosotis', 'Narcissus', 'Orchidaceae', 'Pelargonium', 'Taraxacum', 'Viola', 'Zinnia'];
    const speciesOptions = ['Alpina', 'Biflora', 'Californica', 'Domestica', 'Eximia', 'Fruticosa', 'Gigantea', 'Hirsuta', 'Imperialis', 'Japonica', 'Kewensis', 'Liliflora', 'Macrocarpa', 'Nana', 'Orientalis', 'Picta', 'Quadrifolia', 'Rosmarinifolia', 'Sativum', 'Tenuifolia', 'Umbellata', 'Virginiana', 'Warszewicziana', 'Xanthocarpa', 'Yunnanensis', 'Zebrina'];
    const placeOptions = ['Arboretum', 'Backyard', 'Balcony', 'Botanic reserve', 'Botanical garden', 'Coastline', 'Container', 'Countryside', 'Desert', 'Farmland', 'Forest', 'Garden', 'Greenhouse', 'Hedge', 'Indoor', 'Meadow', 'Mountains', 'Orchard', 'Patio', 'Park', 'Roadside', 'Rock garden', 'Terrarium', 'Vineyard', 'Water garden', 'Wetland', 'Wild'];
    const colorPlantOptions = ['Black', 'Blue', 'Brown', 'Coral', 'Crimson', 'Gold', 'Gray', 'Green', 'Indigo', 'Lavender', 'Maroon', 'Magenta', 'Olive', 'Orange', 'Pink', 'Purple', 'Red', 'Sage', 'Silver', 'Teal', 'Turquoise', 'White', 'Yellow'];
    const collectionNameOptions = ['Aromatic Herbs', 'Botanical Remedies', 'Butterfly Haven', 'Culinary Delights', 'Desert Oasis', 'Drought-tolerant Gems', 'Eco-friendly Plants', 'Edible Treasures', 'Exotic Medicinals', 'Fragrant Favourites', 'Healing Garden', 'Medicinal Marvels', 'Native Flora', 'Ornamental Grasses', 'Pollinator Paradise', 'Rare and Endangered', 'Sacred Plants', 'Shade-loving Beauties', 'Succulent Garden', 'Air-purifying Wonders', 'Native Flora'];
    const hashtagsOptions = ['#beautiful', '#botanical', '#botany', '#blooms', '#floral', '#florallove', '#flowerpower', '#flowerstagram', '#flowers', '#gardenlife', '#gardenlove', '#gardening', '#green', '#greenery', '#instagarden', '#landscape', '#nature', '#naturelovers', '#plantlife', '#plantlover', '#plantsofinstagram', '#plants', '#urbanjungle', '#wildflowers'];

    function getCookie(name) {
      const cookieValue = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
      return cookieValue ? cookieValue.pop() : '';
    }

  });

