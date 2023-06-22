document.addEventListener('DOMContentLoaded', function() {
    const jsonButton = document.getElementById('jsonButton');
    jsonButton.addEventListener('click', downloadJSONFile);
  
    function downloadJSONFile() {
      const collectionUrl = 'http://localhost/TW/BackEnd/getTop?UserId=' + getUserId();
      fetch(collectionUrl, {
          method: 'GET',
          headers: {
            'Authorization': 'Bearer ' + getJWT()
          }
        })
        .then(response => response.json())
        .then(data => {
          const jsonContent = JSON.stringify(data, null, 2);
          const blob = new Blob([jsonContent], { type: 'application/json' });
          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = 'top_plants.json';
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          URL.revokeObjectURL(url);
        })
        .catch(error => console.error('Error:', error));
    }
  
    function getUserId() {
      const jwt = getCookie('User');
      const decodedJwt = parseJwt(jwt);
      return decodedJwt.id;
    }
  
    function getJWT() {
      return getCookie('User');
    }
  
    function getCookie(name) {
      const cookieArr = document.cookie.split(';');
      for (let i = 0; i < cookieArr.length; i++) {
        const cookiePair = cookieArr[i].split('=');
        if (name === cookiePair[0].trim()) {
          return decodeURIComponent(cookiePair[1]);
        }
      }
      return null;
    }
  
    function parseJwt(token) {
      const base64Url = token.split('.')[1];
      const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));
  
      return JSON.parse(jsonPayload);
    }
  });
  