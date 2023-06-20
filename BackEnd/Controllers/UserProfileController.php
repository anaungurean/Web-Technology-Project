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
        $params = $_GET;

        switch ($this->requestMethod) {
            case 'GET':
                if (!empty($params['id'])) {
                    $response = $this->getUserData($params['id']);
                } else {
                    $response = $this->notFoundResponse();
                }
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

    private function getUserData($id): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        
        $userId = $id;

        $user = $this->userDAO->findUser($userId);

        if(!$user) {
            return $this->notFoundResponse();
        }

        $response['body'] = json_encode($user);

        return $response;

    }


    private function notFoundResponse(): array
    {
        $response['body'] = json_encode([
            'error' => 'Not Found'
        ]);
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['content_type_header'] = 'Content-Type: application/json';
        return $response;
    }
}

?>