<?php

class SignUpController {

    public function signUpUser($email, $username, $password) {
        // Create a new instance of User
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPassword($password);

        // Call the UserDAO class to check for existing user
        $userDAO = new UserDAO();
        $existingUser = $userDAO->checkExistingUser($email, $username);

        if ($existingUser) {
            // User already exists
            $response = [
                'success' => false,
                'message' => 'User already exists.'
            ];
        } else {
            
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
        }

        // Send the response as JSON
        echo json_encode($response);
    }
}

?>
