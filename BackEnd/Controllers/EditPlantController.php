<?php

include_once "Database/Database.php";

class EditPlantController
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
            case 'PUT':
                $response = $this->updatePlantData();
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

    private function updatePlantData(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';

        $plantId = $this->request;

        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        $plant = new Plant();
        $plant->setId($plantId);
        $plant->setCommonName($input['common_name']);
        $plant->setScientificName($input['scientific_name']);
        $plant->setFamily($input['family']);
        $plant->setGenus($input['genus']);
        $plant->setSpecies($input['species']);
        $plant->setPlace($input['place']);
        $plant->setDateOfCollection($input['date_of_collection']);
        $plant->setColor($input['color']);
        $plant->setCollectionName($input['collection_name']);
        $plant->setHashtags($input['hashtags']);
        $this->plantDAO->updatePlant($plant);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Plant information updated successfully']);
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
