<?php
class GetMyCollectionController
{
    private $requestMethod;
    private $userId;
    private $plantDAO;

    public function __construct($requestMethod, $userId)
    {
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->plantDAO = new PlantDAO();
    }

    public function processRequest(): void
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getCollectionByUserId();
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

    private function getCollectionByUserId(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';

        $plants = $this->plantDAO->getPlantsByUserId($this->userId);

        if (!$plants) {
            return $this->notFoundResponse();
        }

        $response['body'] = json_encode($plants);

        return $response;
    }

    private function notFoundResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode(array("Result" => "Not Found"));
        return $response;
    }
}


