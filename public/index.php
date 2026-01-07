<?php

declare(strict_types=1);

session_start();


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Core/Auth.php';


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


// Route vers l’espace administrateur
$router->get('/admin', function () {
    Auth::requireAdmin();
    require __DIR__ . '/../app/Controllers/AdminController.php';
    (new AdminController())->index();
});



// Connexion (GET = formulaire, POST = traitement)
$router->get('/login', function () {
    require __DIR__ . '/../app/Controllers/AuthController.php';
    (new AuthController())->showLogin();
});

$router->post('/login', function () {
    require __DIR__ . '/../app/Controllers/AuthController.php';
    (new AuthController())->login();
});

// Déconnexion
$router->get('/logout', function () {
    require __DIR__ . '/../app/Controllers/AuthController.php';
    (new AuthController())->logout();
});

// Formulaire création trajet (ADMIN)
$router->get('/admin/trajets/create', function () {
    Auth::requireAdmin();
    require __DIR__ . '/../app/Views/admin/trajets/create.php';
});

// Traitement création trajet (ADMIN)
$router->post('/admin/trajets/store', function () {
    require __DIR__ . '/../app/Controllers/AdminTrajetController.php';
    (new AdminTrajetController())->store();
});

$router->post('/admin/trajets/delete', function () {
    require __DIR__ . '/../app/Controllers/AdminTrajetController.php';
    (new AdminTrajetController())->delete();
});

// Détail d’un trajet (page)
$router->get('/trajets/:id', function ($id) {
    require __DIR__ . '/../app/Controllers/TrajetController.php';
    (new TrajetController())->show((int)$id);
});

// Formulaire édition trajet (ADMIN)
$router->get('/admin/trajets/:id/edit', function ($id) {
    require __DIR__ . '/../app/Controllers/AdminTrajetController.php';
    (new AdminTrajetController())->edit((int)$id);
});

// Traitement édition trajet (ADMIN)
$router->post('/admin/trajets/:id/update', function ($id) {
    require __DIR__ . '/../app/Controllers/AdminTrajetController.php';
    (new AdminTrajetController())->update((int)$id);
});

// Liste des utilisateurs (ADMIN)
$router->get('/admin/users', function () {
    Auth::requireAdmin();
    require __DIR__ . '/../app/Controllers/AdminUserController.php';
    (new AdminUserController())->index();
});

// Liste des agences (ADMIN)
$router->get('/admin/agences', function () {
    Auth::requireAdmin();
    require __DIR__ . '/../app/Controllers/AdminAgenceController.php';
    (new AdminAgenceController())->index();
});

$router->run();
