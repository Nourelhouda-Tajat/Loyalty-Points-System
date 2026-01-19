<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use App\Controllers\AuthController;

$router = new Router();
$router->add('GET',  '/register', AuthController::class, 'registerForm');
$router->add('POST', '/register', AuthController::class, 'register');

$router->add('GET',  '/login', AuthController::class, 'loginForm');
$router->add('POST', '/login', AuthController::class, 'login');

$router->add('GET', '/logout', AuthController::class, 'logout');

$router->run();