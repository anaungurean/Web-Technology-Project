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
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'];
        $newPassword = $data['password'];

        $usernameExists = $this->userDAO->checkUsernameExists($username);

        if ($usernameExists) {
            $success = $this->userDAO->updatePasswordByUsername($username, $newPassword);

            if ($success) {
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Password updated successfully']);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                header('Content-Type: application/json');
                echo json_encode(['error' => 'An error occurred while updating the password']);
            }
        } else {
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
