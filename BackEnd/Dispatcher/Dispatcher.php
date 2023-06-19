<?php

class Dispatcher{
    public static function dispatch($requestMethod, $request) : void{
        $authController = new AuthController($requestMethod);

        switch($request[0]){
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
            default:
                header("HTTP/1.1 404 Not Found");
                exit();
        }
    }
}