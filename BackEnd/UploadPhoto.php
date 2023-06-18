<?php
if (isset($_POST['submit'])) {
  $targetDirectory = "../BackEnd/Database/PlantsImages/";
  $targetFile = $targetDirectory . basename($_FILES['photoInput']['name']);
  
  if (move_uploaded_file($_FILES['photoInput']['tmp_name'], $targetFile)) {
    echo "File uploaded successfully.";
  } else {
    echo "Error uploading file.";
  }
}
?>
