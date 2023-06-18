function uploadFile() {
    const fileInput = document.getElementById('photoInput');
    const file = fileInput.files[0];

    const formData = new FormData();
    formData.append('photoInput', file);

    fetch('../../BackEnd/UploadPhoto.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (response.ok) {
        console.log('File uploaded successfully.');
        // Handle successful upload
      } else {
        console.error('Error uploading file.');
        // Handle upload error
      }
    })
    .catch(error => {
      console.error('Error:', error);
      // Handle network or fetch error
    });
}