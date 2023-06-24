<?php

include_once "Database/Database.php";

class EditProfileController {

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
                $response = $this->updateUserData();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function updateUserData(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';

        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        $user = new User();
        $user->setId($input['id']);
        $user->setEmail($input['email']);
        $user->setUsername($input['username']);
        // $user->setPassword($input['password']);
        $user->setDescription($input['descriere']);
        $user->setHobby($input['hobby']);
        $user->setInteresPlant($input['interes_plant']);
        $user->setFirstname($input['firstname']);
        $user->setLastname($input['lastname']);
        $user->setPhone($input['phone']);
        $user->setAddress($input['adresa']);
        $this->userDAO->updateUser($user);


        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'User information updated successfully']);
        return $response;
    }


    private function notFoundResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode([
            'error' => 'Not Found'
        ]);
        return $response;
    }
}

?>