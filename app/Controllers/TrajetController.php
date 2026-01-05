<?php

declare(strict_types=1);

require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/Trajet.php';

class TrajetController
{
    public function index(): void
    {
        $trajets = Trajet::all();

        // On affiche la vue
        require __DIR__ . '/../Views/trajets/index.php';
    }
}
