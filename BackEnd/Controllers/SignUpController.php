<?php

require_once '../BackEnd/UserDAO'; // Assuming it's a PHP file
require_once '../BackEnd/Models/UserModel'; // Assuming it's a PHP file

class SignUpController {

    public function signUpUser($email, $username, $password) {
        // Validate the input if needed

        // Create a new instance of UserModel
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPassword($password);

        // Call the UserDAO class to handle the user registration
        $userDAO = new UserDAO();
        $success = $userDAO->createUser($user);

        if ($success) {
            // Registration successful
            $response = [
                'success' => true,
                'message' => 'User registered successfully!'
            ];
        } else {
            // Registration failed
            $response = [
                'success' => false,
                'message' => 'Failed to register user.'
            ];
        }

        // Send the response as JSON
        echo json_encode($response);
    }
}
?>
