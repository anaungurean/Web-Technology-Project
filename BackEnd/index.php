<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the AJAX request
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Include necessary files and classes
    require_once '../BackEnd/UserDAO';
    require_once '../BackEnd/Models/UserModel';
    require_once '../BackEnd/Controllers/SignUpController.php';
     // Other dependencies if needed

    // Create an instance of SignUpController and call the signUpUser method
    $controller = new SignUpController();
    $controller->signUpUser($email, $username, $password);

    // Send the response
    // You can format the response as JSON or any other format depending on your needs
    $response = [
        'success' => true,
        'message' => 'User registered successfully!'
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
     exit;
}
?>