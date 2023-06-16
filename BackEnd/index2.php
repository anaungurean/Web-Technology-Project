<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $username = $_POST['username'];
    $password = $_POST['password'];

    require_once '../BackEnd/UserDAO';
    require_once '../BackEnd/Controllers/LoginController.php';

    // Create an instance of LoginController and call the loginUser method
    $controller = new LoginController();
    $response = $controller->loginUser($username, $password);

    echo ($response);

}
?>