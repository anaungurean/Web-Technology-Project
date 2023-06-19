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
        $params = $_GET; // Retrieve the request parameters

        switch ($this->requestMethod) {
            case 'GET':
                if (!empty($params['id'])) {
                    $response = $this->getPlantById($params['id']);
                } elseif (!empty($params['filename'])) {
                    $response = $this->getPlantByFilename($params['filename']);
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


    private function getPlantById($id): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';

        $plantId = $id;

        $plant = $this->plantDAO->getPlantById($plantId);

        if (!$plant) {
            return $this->notFoundResponse();
        }

        $response['body'] = json_encode($plant);

        return $response;
    }

    private function getPlantByFilename($filename): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';

        $plantFilename = $filename;

        $plant = $this->plantDAO->getPlantByFilename($plantFilename);

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
?>