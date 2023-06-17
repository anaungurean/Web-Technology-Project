<?php

class Dispatcher{
    public static function dispatch($requestMethod, $request) : void{
        $authController = new AuthController($requestMethod);

//        echo $request[0];

        switch($request[0]){
            case 'register':
                $controller = new SignUpController($requestMethod, $request);
                $controller->processRequest();
                break;
            case 'auth':
                $controller = new AuthController($requestMethod);
                $controller->processRequest();
                break;
            default:
                header("HTTP/1.1 404 Not Found");
                exit();
        }
    }
}