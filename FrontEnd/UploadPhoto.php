<?php
if (isset($_FILES['photo'])) {
  $file = $_FILES['photo'];

  $targetDirectory = 'C://xampp//htdocs//TW//FrontEnd//PlantsImages//';

  $filename = uniqid() . '_' . $file['name'];

  $targetPath = $targetDirectory . $filename;

  if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    $response = ['success' => false, 'message' => 'Error moving uploaded file.'];
  } else {
    $response = ['success' => true, 'message' => 'File uploaded successfully.', 'fileName' => $filename];
  }
} else {
  $response = ['success' => false, 'message' => 'No file uploaded.'];
}

header('Content-Type: application/json');

echo json_encode($response);
?>
