// script.js

document.addEventListener('DOMContentLoaded', function() {

     var button = document.getElementById("view-garden-button");

     button.addEventListener("click", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('userId');

        console.log(userId);
        const collectionUrl = `../HTML_Pages/OtherUserGarden.html?userId=${userId}`;
        window.location.href = collectionUrl;

    });
});
