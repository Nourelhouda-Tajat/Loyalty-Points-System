<?php
define('BASE_URL', '/Loyalty Points System/public');
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use App\Controllers\AuthController;
use App\Controllers\HomeController;

$router = new Router();

//index
$router->add('GET', '/', HomeController::class, 'index');

//Authentification 

$router->add('GET',  '/register', AuthController::class, 'registerForm');
$router->add('POST', '/register', AuthController::class, 'register');

$router->add('GET',  '/login', AuthController::class, 'loginForm');
$router->add('POST', '/login', AuthController::class, 'login');

$router->add('GET', '/logout', AuthController::class, 'logout');

$router->run();