<?php
define('BASE_URL', '/Loyalty%20Points%20System/public');

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use App\Controllers\AuthController;
// use App\Controllers\HomeController;
use App\Controllers\ShopController;

$router = new Router();

//home
$router->add('GET', '/', ShopController::class, 'index');

//shop
$router->add('GET', '/cart', ShopController::class, 'cart');
$router->add('POST', '/add-to-cart', ShopController::class, 'addToCart');
$router->add('POST', '/update-cart', ShopController::class, 'updateCart');
$router->add('POST', '/remove-from-cart', ShopController::class, 'removeFromCart');
$router->add('GET', '/checkout', ShopController::class, 'checkout');
$router->add('POST', '/process-checkout', ShopController::class, 'processCheckout');
$router->add('GET', '/purchase-result', ShopController::class, 'purchaseResult');

//authentification 

$router->add('GET',  '/register', AuthController::class, 'registerForm');
$router->add('POST', '/register', AuthController::class, 'register');

$router->add('GET',  '/login', AuthController::class, 'loginForm');
$router->add('POST', '/login', AuthController::class, 'login');

$router->add('GET', '/logout', AuthController::class, 'logout');




$router->run();