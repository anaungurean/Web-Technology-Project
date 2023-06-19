<?php

class Dispatcher
{
    public static function dispatch($requestMethod, $request): void
    {
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
                $controller = new AddPlantController($requestMethod, $request);
                $controller->processRequest();
                break;
            case 'users':
                $controller = new UserProfileController($requestMethod, $request);
                $controller->processRequest();
                break;
            case 'profile':
                $controller = new EditProfileController($requestMethod, $request);
                $controller->processRequest();
                break;
            case 'getPlant':
                if (isset($_GET['id'])) {
                    $plantId = (int) $_GET['id'];
                    // var_dump($plantId);
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
                $userId = null;
                if (isset($_GET['id'])) {
                    $userId = (int) $_GET['id'];
                }
                // var_dump($userId); // debug
                $controller = new GetUserController($requestMethod, $userId);
                $controller->processRequest();
                break;
             case 'getMyCollection':
                 $userId = null;
                if (isset($_GET['UserId'])) {
                    $userId = (int) $_GET['UserId'];
                }
                $controller = new  GetMyCollectionController($requestMethod,$userId);
                $controller->processRequest();
                break;
            case 'getCollections':
                $controller = new  GetAllCollectionController($requestMethod);
                $controller->processRequest();
                break;
            default:
                header("HTTP/1.1 404 Not Found");
                exit();
        }
    }
}
?>