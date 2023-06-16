<?php

class LoginController {
    public function loginUser($username, $password) {
        // Create an instance of UserDAO
        $userDAO = new UserDAO();

        // Check login credentials
        $loggedIn = $userDAO->checkLogin($username, $password);

        if ($loggedIn) {
            // Login successful
            $response = [
                'success' => true,
                'message' => 'Login successful!'
            ];
        } else {
            // Login failed
            $response = [
                'success' => false,
                'message' => 'Incorrect username or password.'
            ];
        }

        // Send the response as JSON
        echo json_encode($response);
    }
}
?>
