document.addEventListener('DOMContentLoaded', function() {

    var deleteButton = document.getElementById("delete-plant-button");

    var jwt = getCookie("User");
    
    const urlParams = new URLSearchParams(window.location.search);
    const plantId = urlParams.get('id');

    const deleteUrl = `http://localhost/TW/BackEnd/deletePlant?id=${plantId}`;

    deleteButton.addEventListener("click", function() {
       
        var confirmed = confirm("Are you sure that you want to delete this plant?");
        
        if (confirmed) {
            
             fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                'Authorization': `Bearer ${jwt}`
                }
            })
            .then(response => {
                if (response.ok) {
                    console.log("Plant deleted!");
                    const collectionUrl = `../HTML_Pages/MyGarden.html`;
                    window.location.href = collectionUrl;
                } else {
                    console.error("Failed to delete plant.");
                }
            })
            .catch(error => {
                console.error("An error occurred during plant deletion:", error);
            });
        } else {

        }
    });
});

function getCookie(name) {
    const cookieValue = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return cookieValue ? cookieValue.pop() : '';
}
