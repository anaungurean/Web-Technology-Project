document.addEventListener("DOMContentLoaded", function() {
             var cookieExists = document.cookie.indexOf("jwt") >= 0;
 
       if (cookieExists) {
            window.location.href = "../HTML_Pages/WelcomeLoggedIn.html";
        }
        
});