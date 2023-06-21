<?php
class DeletePlantController {
    private $requestMethod;
    private $plantDAO;

    public function __construct($requestMethod, $request)
    {
        $this->requestMethod = $requestMethod;
        $this->request = $request;
        $this->plantDAO = new PlantDAO();
    }

    public function processRequest(): void
    {
        $params = $_GET;

        switch ($this->requestMethod) {
            case 'DELETE':
                if (!empty($params['id'])) {
                    $response = $this->deletePlant($params['id']);
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

    private function deletePlant($id): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';

        $plantId = $id;

        $plant = $this->plantDAO->getPlantById($plantId);

        if (!$plant) {
            return $this->notFoundResponse();
        }

        $this->plantDAO->deletePlant($plantId);

        $response['body'] = json_encode(['message' => 'Plant deleted successfully']);

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
