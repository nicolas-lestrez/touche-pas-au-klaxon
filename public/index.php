<?php

declare(strict_types=1);

// Autoload ultra simple (sans Composer pour l’instant)
require __DIR__ . '/../app/Controllers/HomeController.php';

// Route "home" par défaut
$controller = new HomeController();
$controller->index();
