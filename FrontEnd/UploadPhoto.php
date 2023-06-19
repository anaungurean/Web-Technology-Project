<?php
// Check if a file was uploaded
if (isset($_FILES['photo'])) {
  $file = $_FILES['photo'];

  // Specify the directory where you want to save the uploaded file
  $targetDirectory = 'C://xampp//htdocs//TW//FrontEnd//PlantsImages//';

  // Generate a unique filename for the uploaded file
  $filename = uniqid() . '_' . $file['name'];

  // Create the full path to save the file
  $targetPath = $targetDirectory . $filename;

  if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    // Error moving the uploaded file
    $response = ['success' => false, 'message' => 'Error moving uploaded file.'];
  } else {
    // File uploaded successfully
    $response = ['success' => true, 'message' => 'File uploaded successfully.', 'fileName' => $filename];
  }
} else {
  // No file was uploaded
  $response = ['success' => false, 'message' => 'No file uploaded.'];
}

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Encode the response as JSON and send it
echo json_encode($response);
?>
