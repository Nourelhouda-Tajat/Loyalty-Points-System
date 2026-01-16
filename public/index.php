
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/Router.php';

$router = new Router();

$router->add('/', HomeController::class, 'index');
$router->run();