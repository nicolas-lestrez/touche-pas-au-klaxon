<?php

declare(strict_types=1);

require_once __DIR__ . '/../Models/Trajet.php';

class TrajetController
{
    public function index(): void
    {
        // On récupère les trajets (avec villes départ/arrivée)
        $trajets = Trajet::availableUpcoming();


        // On affiche la vue "liste des trajets"
        require __DIR__ . '/../Views/trajets/index.php';
        // ⚠️ Si ta vue s'appelle autrement, mets le bon chemin :
        // require __DIR__ . '/../Views/trajets.php';
        // ou require __DIR__ . '/../Views/home.php';
    }
}
