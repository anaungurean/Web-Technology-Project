<?php
class SignUpController {
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
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        header($response['content_type_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }


    private function createUserFromRequest(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 201 CREATED';
        $response['content_type_header'] = 'Content-Type: application/json';

        $input = (array) json_decode(file_get_contents('php://input'), TRUE);


        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }
        $user = new User($input['email'], $input['username'], $input['password']);

        if(!($this->userDAO->findByEmail($user->getEmail())))
        {
            $this->userDAO->createUser($user);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(array("Result"=>"User created successfully"));
        }
        else
        {
            $response['status_code_header'] = 'HTTP/1.1 409 Conflict';
            $response['body'] = json_encode(array("Result"=>"User exist"));
        }

        return $response;
    }

    private function validateUser(array $input): bool
    {
        if (!isset($input['email'])) {
            return false;
        }
        if (!isset($input['username'])) {
            return false;
        }
        if (!isset($input['password'])) {
            return false;
        }
        return true;
    }


    private function notFoundResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode(array("Result"=>"Not Found"));
        return $response;
    }


    private function unprocessableEntityResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }


}