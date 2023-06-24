<?php

class Dispatcher
{
    public static function dispatch($requestMethod, $request): void
    {
        $authController = new AuthController($requestMethod);
        switch ($request[0]) {
            case 'register':
                $controller = new SignUpController($requestMethod, $request);
                $controller->processRequest();
                break;
            case 'auth':
                $controller = new AuthController($requestMethod);
                $controller->processRequest();
                break;
            case 'addPlant':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $controller = new AddPlantController($requestMethod, $request);
                $controller->processRequest();
                break;
            case 'users':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $userId = (int) $_GET['id'];
                $controller = new UserProfileController($requestMethod, $userId);
                $controller->processRequest();
                break;
            case 'profile':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $controller = new EditProfileController($requestMethod, $request);
                $controller->processRequest();
                break;
            case 'getPlant':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                if (isset($_GET['id'])) {
                    $plantId = (int) $_GET['id'];
                    $controller = new GetPlantController($requestMethod, $plantId);
                } elseif (isset($_GET['filename'])) {
                    $filename = $_GET['filename'];
                    $controller = new GetPlantController($requestMethod, $filename);
                } else {
                    header("HTTP/1.1 404 Not Found");
                    exit();
                }
                $controller->processRequest();
                break;
            case 'getUser':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $userId = null;
                if (isset($_GET['id'])) {
                    $userId = (int) $_GET['id'];
                }
                $controller = new GetUserController($requestMethod, $userId);
                $controller->processRequest();
                break;
            case 'getMyCollection':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                 $userId = null;
                if (isset($_GET['UserId'])) {
                    $userId = (int) $_GET['UserId'];
                }
                $controller = new  GetMyCollectionController($requestMethod,$userId);
                $controller->processRequest();
                break;
            case 'getCollections':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $controller = new  GetAllCollectionController($requestMethod);
                $controller->processRequest();
                break;
            case 'deleteUser':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $userId = null;
                if (isset($_GET['id'])) {
                    $userId = (int) $_GET['id'];
                }
                $controller = new DeleteUserController($requestMethod, $userId);
                $controller->processRequest();
                break;
            case 'getTop':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $controller = new  GetTopController($requestMethod);
                $controller->processRequest();
                break;
            case 'updatePassword':
                $controller = new UpdatePasswordController($requestMethod, $request);
                $controller->processRequest();
                break;
            case 'updatePlant':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $plantId = null;
                if (isset($_GET['id'])) {
                    $plantId = (int) $_GET['id'];
                }
                $controller = new EditPlantController($requestMethod, $plantId);
                $controller->processRequest();
                break;
            case 'deletePlant':
                $jwt = $authController-> checkJWTExistence();
                $authController -> validateJWT($jwt);
                $plantId = null;
                if (isset($_GET['id'])) {
                    $plantId = (int) $_GET['id'];
                }
                $controller = new DeletePlantController($requestMethod, $plantId);
                $controller->processRequest();
                break;   
            default:
                header("HTTP/1.1 404 Not Found");
                exit();
        }
    }
}
?>