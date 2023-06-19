<?php
class GetPlantController
{

    private $requestMethod;
    private $request;
    private $plantDAO;

    public function __construct($requestMethod, $request)
    {
        $this->requestMethod = $requestMethod;
        $this->request = $request;
        $this->plantDAO = new PlantDAO();
    }

    public function processRequest(): void
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getPlantById();
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

    private function getPlantById(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';


        $plantId = $this->request;
        $plant = $this->plantDAO->getPlantById($plantId);

        if (!$plant) {
            return $this->notFoundResponse();
        }

        $response['body'] = json_encode($plant);

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

