<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;

$router = new Router();

// Accueil
$router->get('/', function () {
    require __DIR__ . '/../app/Controllers/HomeController.php';
    (new HomeController())->index();
});

// Test base de données
$router->get('/db-test', function () {
    require __DIR__ . '/../app/Controllers/DbTestController.php';
    (new DbTestController())->index();
});

$router->run();
