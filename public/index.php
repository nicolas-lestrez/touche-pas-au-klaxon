<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;

$router = new Router();

// Accueil => liste des trajets
$router->get('/', function () {
    require __DIR__ . '/../app/Controllers/TrajetController.php';
    (new TrajetController())->index();
});

// Route explicite /trajets (au cas où)
$router->get('/trajets', function () {
    require __DIR__ . '/../app/Controllers/TrajetController.php';
    (new TrajetController())->index();
});

// Test base de données (tu l’as déjà)
$router->get('/db-test', function () {
    require __DIR__ . '/../app/Controllers/DbTestController.php';
    (new DbTestController())->index();
});

$router->run();
