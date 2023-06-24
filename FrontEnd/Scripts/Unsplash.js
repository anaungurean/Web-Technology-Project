document.addEventListener('DOMContentLoaded', function() {
  
  function handleFormSubmit(event) {
    event.preventDefault(); 

    const keyword = document.querySelector('input[name="keyword"]').value;

    fetch(`https://api.unsplash.com/search/photos?query=${keyword}&client_id=oBviRm_WaE1aZ7k4Ul0RVHN0L9hsFfSfYgxSK2ONfvw`)
      .then(response => response.json())
      .then(data => {
        displayPhotos(data.results);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

function displayPhotos(photos) {
  const plantsContainer = document.getElementById('plantsContainer');

  plantsContainer.innerHTML = '';

  photos.forEach(photo => {
    const imgElement = document.createElement('img');
    imgElement.src = photo.urls.regular;
    imgElement.alt = photo.alt_description;

    const linkElement = document.createElement('a');
    linkElement.href = photo.links.html;
    linkElement.target = '_blank'; 
    linkElement.appendChild(imgElement);

    plantsContainer.appendChild(linkElement);
  });
}

  const searchForm = document.getElementById('searchForm');
  searchForm.addEventListener('submit', handleFormSubmit);
});
