<?php

class UpdatePasswordController {
    private $requestMethod;
    private $request;
    private $userDAO;

    public function __construct($requestMethod, $request)
    {
        $this->requestMethod = $requestMethod;
        $this->request = $request;
        $this->userDAO = new UserDAO();
    }

    public function processRequest(): void
    {
        switch ($this->requestMethod) {
            case 'PUT':
                $this->updatePassword();
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    private function updatePassword(): void
    {
        // Get the username and new password from the request body
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'];
        $newPassword = $data['password'];

        // Check if the username exists
        $usernameExists = $this->userDAO->checkUsernameExists($username);

        if ($usernameExists) {
            // Update the password for the given username
            $success = $this->userDAO->updatePasswordByUsername($username, $newPassword);

            // Check if the update was successful
            if ($success) {
                // Return a success response
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Password updated successfully']);
            } else {
                // Return an error response
                header('HTTP/1.1 500 Internal Server Error');
                header('Content-Type: application/json');
                echo json_encode(['error' => 'An error occurred while updating the password']);
            }
        } else {
            // Return an error response if the username does not exist
            header('HTTP/1.1 404 Not Found');
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Username not found']);
        }
    }

    private function notFoundResponse(): void
    {
        header('HTTP/1.1 404 Not Found');
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Not Found']);
    }
}
?>
