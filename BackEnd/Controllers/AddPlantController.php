<?php
class AddPlantController {

    private $requestMethod;
    private $request;
    private $plantDAO;

    public function __construct($requestMethod, $request)
    {
        $this->requestMethod = $requestMethod;
        $this->request = $request;
        $this->plantDAO = new plantDAO();
    }

    public function processRequest(): void
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createPlantFromRequest();
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


    // private function createPlantFromRequest(): array
    // {
    //     $response['status_code_header'] = 'HTTP/1.1 201 CREATED';
    //     $response['content_type_header'] = 'Content-Type: application/json';

    //     $input = (array) json_decode(file_get_contents('php://input'), true);

    //     if (!$this->validatePlant($input)) {
    //         return $this->unprocessableEntityResponse();
    //     }

    //     // Assuming you have the JWT stored in a cookie 
    //     $jwtCookie = $_COOKIE['User'];

    //     // Decode the JWT
    //     $decodedJWT = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $jwtCookie)[1]))), true);

    //     // Check if the JWT is valid and contains the 'id' field
    //     if (isset($decodedJWT['id'])) {
    //         $userId = $decodedJWT['id'];

    //         $plant = new Plant();
    //         $plant->setIdUser($userId);
    //         $plant->setCommonName($input['common_name']);
    //         $plant->setScientificName($input['scientific_name']);
    //         $plant->setFamily($input['family']);
    //         $plant->setGenus($input['genus']);
    //         $plant->setSpecies($input['species']);
    //         $plant->setPlace($input['place']);
    //         $plant->setDateOfCollection($input['date_of_collection']);
    //         $plant->setColor($input['color']);
    //         $plant->setCollectionName($input['collection_name']);
    //         $plant->setHashtags($input['hashtags']);

    //         $this->plantDAO->createPlant($plant);

    //         $response['status_code_header'] = 'HTTP/1.1 201 Created';
    //         $response['body'] = json_encode(array(
    //             "Result" => "Plant created successfully",
    //         ));
    //     } else {
    //         // Handle the case when the JWT is invalid or doesn't contain the 'id' field
    //         $response['status_code_header'] = 'HTTP/1.1 401 Unauthorized';
    //         $response['body'] = json_encode(array(
    //             "Error" => "Unauthorized access",
    //         ));
    //     }

    //     return $response;
    // }

    private function createPlantFromRequest(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 201 CREATED';
        $response['content_type_header'] = 'Content-Type: application/json';

        $input = (array) json_decode(file_get_contents('php://input'), true);

        if (!$this->validatePlant($input)) {
            return $this->unprocessableEntityResponse();
        }

        $plant = new Plant();
        $plant->setIdUser($input['user_id']);
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

        $this->plantDAO->createPlant($plant);

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode(array(
            "Result" => "Plant created successfully",
        ));

        return $response;
    }




    private function validatePlant(array $input): bool
    {
        if (!isset($input['common_name'])) {
            return false;
        }
        if (!isset($input['scientific_name'])) {
            return false;
        }
        if (!isset($input['family'])) {
            return false;
        }
        if (!isset($input['genus'])) {
            return false;
        }
        if (!isset($input['species'])) {
            return false;
        }
        if (!isset($input['place'])) {
            return false;
        }
        if (!isset($input['date_of_collection'])) {
            return false;
        }
        if (!isset($input['color'])) {
            return false;
        }
        if (!isset($input['collection_name'])) {
            return false;
        }
        if (!isset($input['hashtags'])) {
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