function uploadFile(callback) {
  const fileInput = document.getElementById('photoInput');
  const file = fileInput.files[0];

  const formData = new FormData();
  formData.append('photo', file);

  fetch('http://localhost/TW/FrontEnd/UploadPhoto.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const photoFileName = data.fileName;
      callback(photoFileName);  
      console.log('File uploaded successfully:', data);
      displayMessage('The photo was uploaded.');  
    } else {
      console.error('Error uploading file:', data.message);
    }
  })
  .catch(error => {
    console.error('Error uploading file:', error);
  });
}

function displayFileName(photoFileName) {
  const fileNameElement = document.getElementById('FileName');
  fileNameElement.textContent = photoFileName;
}

function displayMessage(message) {
  const messageElement = document.getElementById('message');
  messageElement.textContent = message;
}
