document.addEventListener('DOMContentLoaded', function() {

    var deleteButton = document.getElementById("delete-account-button");
    var jwt = getCookie("User");
    var decodedJwt = parseJwt(jwt);
    var id_user = decodedJwt.id;
    const deleteUrl = `http://localhost/TW/BackEnd/deleteUser?id=${id_user}`;

    deleteButton.addEventListener("click", function() {
        var confirmed = confirm("Are you sure that you want to delete your account?");
        
        if (confirmed) {
            fetch(deleteUrl, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    console.log("Account deleted!");
                    logout();
                    const collectionUrl = `../HTML_Pages/Welcome.html`;
                    window.location.href = collectionUrl;
                } else {
                    console.error("Failed to delete account.");
                }
            })
            .catch(error => {
                console.error("An error occurred during account deletion:", error);
            });
        } else {
            // If the user clicked "No" do nothing
        }
    });
});

function logout() {
  var cookies = document.cookie.split(";");

  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];
    var eqPos = cookie.indexOf("=");
    var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
  }
  
}