<?php


class UserProfileController {

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
            case 'GET':
                $response = $this->getUserData();
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

    private function getUserData(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $jwtCookie = $_COOKIE['User'];
        
        $decodedJWT = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $jwtCookie)[1]))), true);
        $userId = $decodedJWT['id'];

        $user = $this->userDAO->findUser($userId);

        if(!$user) {
            return $this->notFoundResponse();
        }

        $response['body'] = json_encode($user);

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