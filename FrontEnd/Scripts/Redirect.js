document.addEventListener("DOMContentLoaded", function() {
    var userCookie = getCookie("User");
    if (userCookie) {
        var jwt = userCookie;
        var isValid = validateJWT(jwt);
        if (!isValid) {
            deleteCookie("User");
            showAlertAndRedirect("You aren't logged in anymore. Please sign in.");
        }
    } else {
        showAlertAndRedirect("You aren't logged in anymore. Please sign in.");
    }

    function getCookie(cookieName) {
        var name = cookieName + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookieArray = decodedCookie.split(";");

        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i].trim();
            if (cookie.indexOf(name) === 0) {
                return cookie.substring(name.length, cookie.length);
            }
        }

        return null;
    }

    function validateJWT(jwt) {
        var jwtPattern = /^[\w-]+\.[\w-]+\.[\w-]+$/;
        return jwtPattern.test(jwt);
    }

    function deleteCookie(cookieName) {
        document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }

    function showAlertAndRedirect(message) {
        alert(message);
        window.location.href = "../HTML_Pages/SignIn.html";
    }
});
