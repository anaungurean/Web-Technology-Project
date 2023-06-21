<?php


require_once ($_SERVER['DOCUMENT_ROOT'] . '/TW/vendor/autoload.php');

include_once "../BackEnd/Controllers/SignUpController.php";
include_once "../BackEnd/Controllers/AuthController.php";
include_once "../BackEnd/Controllers/AddPlantController.php";

include_once "../BackEnd/Controllers/UserProfileController.php";
include_once "../BackEnd/Controllers/EditProfileController.php";

include_once "../BackEnd/Controllers/GetPlantController.php";
include_once "../BackEnd/Controllers/GetUserController.php";
include_once "../BackEnd/Controllers/GetMyCollectionController.php";
include_once "../BackEnd/Controllers/GetAllCollectionController.php";
include_once "../BackEnd/Controllers/DeleteUserController.php";
include_once "../BackEnd/Controllers/GetTopController.php";
include_once "../BackEnd/Controllers/UpdatePasswordController.php";
 
include_once "../BackEnd/Database/UserDAO.php";
include_once "../BackEnd/Database/PlantDAO.php";

include_once "../BackEnd/Models/User.php";
include_once "../BackEnd/Models/Plant.php";

include_once "../BackEnd/Dispatcher/Dispatcher.php";



    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

 

    $request = [];
    for($i = 3; $i < count($uri); $i++){
        $request[] = $uri[$i];
    }



    $requestMethod = $_SERVER['REQUEST_METHOD'];

    Dispatcher::dispatch($requestMethod, $request);