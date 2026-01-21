<?php
define('BASE_URL', '/Loyalty%20Points%20System/public');
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ShopController;

$router = new Router();

//home
$router->add('GET', '/', HomeController::class, 'index');

//authentification 

$router->add('GET',  '/register', AuthController::class, 'registerForm');
$router->add('POST', '/register', AuthController::class, 'register');

$router->add('GET',  '/login', AuthController::class, 'loginForm');
$router->add('POST', '/login', AuthController::class, 'login');

$router->add('GET', '/logout', AuthController::class, 'logout');

//shop
$router->add('GET', '/shop', ShopController::class, 'index');
$router->add('GET', '/shop/cart', ShopController::class, 'cart');
$router->add('POST', '/shop/cart-to-cart', ShopController::class, 'addToCart');
$router->add('POST', '/shop/update-cart', ShopController::class, 'updateCart');
$router->add('POST', '/shop/remove-from-cart', ShopController::class, 'removeFromCart');
$router->add('GET', '/shop/checkout', ShopController::class, 'checkout');
$router->add('POST', '/shop/process-checkout', ShopController::class, 'processCheckout');
$router->add('GET', '/shop/purchase-result', ShopController::class, 'purchaseResult');



$router->run();