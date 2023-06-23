// Unsplash.js

document.addEventListener('DOMContentLoaded', function() {
  // Function to handle the form submission
  function handleFormSubmit(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the input value
    const keyword = document.querySelector('input[name="keyword"]').value;

    // Make a fetch request to the Unsplash API
    fetch(`https://api.unsplash.com/search/photos?query=${keyword}&client_id=oBviRm_WaE1aZ7k4Ul0RVHN0L9hsFfSfYgxSK2ONfvw`)
      .then(response => response.json())
      .then(data => {
        // Process the retrieved data
        displayPhotos(data.results);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  // Function to display the retrieved photos on the page
function displayPhotos(photos) {
  const plantsContainer = document.getElementById('plantsContainer');

  // Clear previous results
  plantsContainer.innerHTML = '';

  // Iterate over the retrieved photos and create HTML elements to display them
  photos.forEach(photo => {
    const imgElement = document.createElement('img');
    imgElement.src = photo.urls.regular;
    imgElement.alt = photo.alt_description;

    const linkElement = document.createElement('a');
    linkElement.href = photo.links.html;
    linkElement.target = '_blank'; // Open the link in a new tab
    linkElement.appendChild(imgElement);

    plantsContainer.appendChild(linkElement);
  });
}


  // Add event listener to the form
  const searchForm = document.getElementById('searchForm');
  searchForm.addEventListener('submit', handleFormSubmit);
});
