<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController
{

    private $requestMethod;
    private $secret_Key  = '%aaSWvtJ98os_b<IQ_c$j<_A%bo_[xgct+j$d6LJ}^<pYhf+53k^-R;Xs<l%5dF';
    private $domainName = "https://127.0.0.1";
    private $userDAO;

    /**
     * @param $requestMethod
     */
    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        $this->userDAO = new UserDAO();

    }
    
    public function processRequest(): void {

        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->signIn();
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



   private function signIn(): array
{
    $response['status_code_header'] = 'HTTP/1.1 201 CREATED';
    $response['content_type_header'] = 'Content-Type: application/json';

    $input = (array) json_decode(file_get_contents('php://input'), TRUE);

    if (!$this->validateUser($input)) {
        return $this->unprocessableEntityResponse();
    }

    $user = new User();
    $user->setUsername($input['username']);
    $user->setPassword($input['password']);

    $loggedInUserId = $this->userDAO->checkLogin($user->getUsername(), $user->getPassword());

    if ($loggedInUserId !== null) {
        $jwtResponse = $this->createJWT($user->getUsername(), $loggedInUserId);
        $jwt = $jwtResponse['body'];

        // Set the JWT as a cookie

        $response['body'] = json_encode(array(
            "jwt" => $jwt,
            "message" => "Authentication successful"
        ));
                
        setcookie('User', $jwt, time() + 30 * 24 * 60 * 60, '/');

    } 
    
    else {
        $response['status_code_header'] = 'HTTP/1.1 401 No-authorized';
        $response['body'] = json_encode(array(
            "Result" => "Invalid info."
        ));
    }

    return $response;
}

    private function createJWT($username, $id) {

        $secret_Key = $this -> secret_Key;
        $date   = new DateTimeImmutable();
        $expire_at     = $date->modify('+6 minutes')->getTimestamp();
        $domainName = $this -> domainName;
        $request_data = [
            'iat'  => $date->getTimestamp(),         // ! Issued at: time when the token was generated
            'iss'  => $domainName,                   // ! Issuer
            'nbf'  => $date->getTimestamp(),         // ! Not before
            'exp'  => $expire_at,                    // ! Expire
            'username' => $username, 
            'id' => $id,                // User name
        ];

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = JWT::encode(
            $request_data,
            $secret_Key,
            'HS512'
        );

        return $response;

    }

        private function validateUser(array $input): bool
    {
        if (!isset($input['username'])) {
            return false;
        }
        if (!isset($input['password'])) {
            return false;
        }
        return true;
    }

    function checkJWTExistence () {
        // Check JWT
        if (! preg_match('/Bearer\s(\S+)/', $this -> getAuthorizationHeader(), $matches)) {
            header('HTTP/1.0 400 Bad Request');
            echo 'Token not found in request';
            exit;
        }
        return $matches[1];
    }

    function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    public function validateJWT( $jwt ) {
        $secret_Key = $this -> secret_Key;

        try {
            $token = JWT::decode($jwt, new Key($secret_Key, 'HS512'));
        } catch (Exception $e) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
        $now = new DateTimeImmutable();
        $domainName = $this -> domainName;

        if ($token->iss !== $domainName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp())
        {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
    }

    private function unprocessableEntityResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

        private function notFoundResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['content_type_header'] = 'Content-Type: application/json';
        $response['body'] = json_encode(array("Result"=>"Not Found"));
        return $response;
    }

}