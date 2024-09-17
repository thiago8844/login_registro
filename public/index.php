<?php 

include __DIR__ . "/../vendor/autoload.php";

use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\RegisterController;
use App\Router;

// echo "<pre>";
// print_r($_SERVER);
// echo "<pre>";



//Controllers function



//Router
$router = new Router();

//views
$router->addRoute("/", "GET", [HomeController::class, "renderHomeView"]);
$router->addRoute("/login", "GET", [LoginController::class, "renderLoginView"]);
$router->addRoute("/cadastro", "GET", [RegisterController::class, "renderRegisterView"]);


//POST
$router->addRoute("/user", "POST", [RegisterController::class, "createUser"]);


$router->routerDespatcher($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
?>
