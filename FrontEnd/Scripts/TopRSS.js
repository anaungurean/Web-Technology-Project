document.addEventListener('DOMContentLoaded', function() {
    fetchTopPlants()
      .then(data => {
        const xmlContainer = document.getElementById('xmlContainer');
        const rssFeed = generateRSSFeed(data);
        xmlContainer.textContent = rssFeed;
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
            downloadXMLFile(collectionData);
            return collectionData;
          } else {
            throw new Error('No top plants found.');
          }
        });
    }
  
    function generateRSSFeed(data) {
      let rssFeed = '<?xml version="1.0" encoding="UTF-8"?>\n';
      rssFeed += '<plants>\n';
  
      rssFeed += '  <title>Top Plants Ranking</title>\n';
      rssFeed += '  <link>http://localhost/TW/FrontEnd/HTML_Pages/TopRSS.html</link>\n';
      rssFeed += '  <description>Top 2 most popular plants ranking</description>\n';
  
      data.slice(0, 2).forEach(plant => {
        rssFeed += '  <plant>\n';
        rssFeed += `    <_id>${plant.id}</_id>\n`;
        rssFeed += `    <id_user>${plant.id_user}</id_user>\n`;
        rssFeed += `    <description>${plant.common_name} is a popular plant.</description>\n`;
        rssFeed += `    <common_name>${plant.common_name}</common_name>\n`;
        rssFeed += `    <scientific_name>${plant.scientific_name}</scientific_name>\n`;
        rssFeed += `    <family>${plant.family}</family>\n`;
        rssFeed += `    <genus>${plant.genus}</genus>\n`;
        rssFeed += `    <species>${plant.species}</species>\n`;
        rssFeed += `    <place>${plant.place}</place>\n`;
        rssFeed += `    <date_of_collection>${plant.date_of_collection}</date_of_collection>\n`;
        rssFeed += `    <color>${plant.color}</color>\n`;
        rssFeed += `    <collection_name>${plant.collection_name}</collection_name>\n`;
        rssFeed += `    <hashtags>${plant.hashtags}</hashtags>\n`;
        rssFeed += `    <filename>${plant.filename}</filename>\n`;
        rssFeed += '  </plant>\n';
      });
  
      rssFeed += '</plants>\n';
  
      return rssFeed;
    }


    function downloadXMLFile(data) {
      const rssFeed = generateRSSFeed(data);
    
      const blob = new Blob([rssFeed], { type: 'application/xml' });
      const url = URL.createObjectURL(blob);
    
      const a = document.createElement('a');
      a.href = url;
      a.download = 'top_rss.xml';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
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