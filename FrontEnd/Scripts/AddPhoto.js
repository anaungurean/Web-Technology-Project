function uploadFile() {
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
    // console.log('File uploaded successfully:', data);
    // Optionally, display a success message to the user
  })
  .catch(error => {
    // console.error('Error uploading file:', error);
    // Optionally, display an error message to the user
  });
}
