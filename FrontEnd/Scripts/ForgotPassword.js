document.getElementById("password-form").addEventListener("submit", function (event) {
  event.preventDefault();  

  var emailInput = document.getElementById("email");
  var email = emailInput.value.trim();

  if (!email) {
     document.getElementById("response-message").textContent = "Please enter your email address.";
    return;
  }
  document.getElementById("response-message").textContent = "Recovering...";
 
  var form = new FormData();
  form.append("email", email);

   fetch("../PasswordReset.php", {
    method: "POST",
    body: form,
  })
    .then(function (response) {
      if (response.ok) {
        return response.text();
      } else {
        throw new Error("Error: " + response.status);
      }
    })
    .then(function (data) {
       document.getElementById("response-message").textContent = data;
       emailInput.value = "";
    })
    .catch(function (error) {
       document.getElementById("response-message").textContent = "Failed to reset password. Please try again later.";
      console.error(error);
    });
});
