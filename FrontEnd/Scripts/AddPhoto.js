function handleFileSelect(event) {
  const fileInput = event.target;
  const file = fileInput.files[0];

  if (file) {
    // Create a FormData object to store the file
    const formData = new FormData();
    formData.append('image', file);
   console.log("annanan");
    // Send the file to the server using fetch
    fetch('../../BackEnd/UploadPhoto.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.text())
      .then(result => {
        // Handle the server response
        console.log(result);
      })
      .catch(error => {
        // Handle any errors that occurred during the upload
        console.error('Error:', error);
      });
  }
}
