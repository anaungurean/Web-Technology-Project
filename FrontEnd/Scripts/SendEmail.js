document.getElementById("contactForm").addEventListener("submit", function (event) {
  event.preventDefault(); 

  var form = new FormData(this);
  var statusMessage = document.getElementById("status-message");
  statusMessage.textContent = "Sending...";

  if (form.get("name") && form.get("email") && form.get("subject") && form.get("message")) {
    fetch(this.action, {
      method: this.method,
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
        statusMessage.innerHTML = data;
        document.getElementById("contactForm").reset();
        statusMessage.textContent = "Thank you! Your message has been sent.";
      })
      .catch(function (error) {
        statusMessage.textContent = "Sorry, there was an error sending your message. Please try again later.";
        console.error(error);
      });
  } else {
    statusMessage.textContent = "Please fill out all the form fields before submitting.";
  }
});
