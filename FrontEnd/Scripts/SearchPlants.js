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
  // Remove leading and trailing spaces (if any)
  keyword = keyword.trim();

  // Split the keyword into an array of words
  var wordArray = keyword.split(' ');

  // Capitalize the first letter of each word
  wordArray = wordArray.map(function(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
  });

  return wordArray;
}



 