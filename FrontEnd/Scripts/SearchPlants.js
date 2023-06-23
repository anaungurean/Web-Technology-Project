document.addEventListener('DOMContentLoaded', function() {
  var searchForm = document.getElementById('searchForm');
  var searchButton = document.getElementById('searchButton');

  searchButton.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the form from submitting

    var keyword = searchForm.keyword.value;
    var words = createWordArray(keyword);

    const queryString = `?words=${encodeURIComponent(JSON.stringify(words))}`;
    window.location.href = `../HTML_Pages/PlantsSearched.html${queryString}`;
  });
});


function createWordArray(keyword) {
  keyword = keyword.trim();

  var wordArray = keyword.split(' ');

  wordArray = wordArray.map(function(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
  });

  return wordArray;
}



 