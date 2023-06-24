document.addEventListener('DOMContentLoaded', function() {
    fetchTopPlants()
      .then(data => {
        const csvButton = document.getElementById('csvButton');
        csvButton.addEventListener('click', () => {
          downloadCSV(data, 'top_plants.csv');
        });
      })
      .catch(error => console.error('Error:', error));
  
    function fetchTopPlants() {
      var jwt = getCookie("User");
      var decodedJwt = parseJwt(jwt);
      var id_user = decodedJwt.id;
  
      const collectionUrl = `http://localhost/TW/BackEnd/getTop?UserId=${id_user}`;
      return fetch(collectionUrl, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${jwt}`
          }
        })
        .then(response => response.json())
        .then(collectionData => {
          if (Array.isArray(collectionData) && collectionData.length > 0) {
            return collectionData;
          } else {
            throw new Error('No top plants found.');
          }
        });
    }
  
    function convertToCSV(data) {
        const csvHeader = Object.keys(data[0]).join(';') + '\n';
        const csvRows = data.map(obj => {
          return Object.values(obj).map(value => {
            if (typeof value === 'string') {
              value = value.replace(/"/g, '""');
              return `"${value}"`;
            }
            return value;
          }).join(';');
        }).join('\n');
        return csvHeader + csvRows;
      }
      
  
    function downloadCSV(data, filename) {
      const csv = convertToCSV(data);
  
      const csvBlob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  
      if (navigator.msSaveBlob) {
        navigator.msSaveBlob(csvBlob, filename);
      } else {
        const link = document.createElement('a');
        if (link.download !== undefined) {
          const csvUrl = URL.createObjectURL(csvBlob);
          link.setAttribute('href', csvUrl);
          link.setAttribute('download', filename);
          link.style.visibility = 'hidden';
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        }
      }
    }
  
    function getCookie(name) {
      var cookieArr = document.cookie.split(";");
      for (var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        if (name === cookiePair[0].trim()) {
          return decodeURIComponent(cookiePair[1]);
        }
      }
      return null;
    }
  
    function parseJwt(token) {
      var base64Url = token.split('.')[1];
      var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));
  
      return JSON.parse(jsonPayload);
    }
});
  