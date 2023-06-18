<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Specify the target folder where you want to save the uploaded file
  $targetFolder = '../BackEnd/Database/PlantsImages/';

  // Get the uploaded file information
  $uploadedFile = $_FILES['image'];

  // Extract the file name
  $fileName = $uploadedFile['name'];

  // Create the target path
  $targetPath = $targetFolder . $fileName;

  // Move the uploaded file to the target folder
  if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
    // File upload successful
    echo 'File uploaded successfully';
  } else {
    // File upload failed
    echo 'Error uploading file';
  }
} else {
  // Invalid request method
  echo 'Invalid request method';
}
?>
