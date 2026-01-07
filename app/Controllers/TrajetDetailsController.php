<?php

declare(strict_types=1);

require_once __DIR__ . '/../Models/Trajet.php';

class TrajetDetailsController
{
    public function show(int $id): void
    {
        $trajet = Trajet::findWithAgencesById($id);

        if (!$trajet) {
            http_response_code(404);
            echo "<h1>404 - Trajet introuvable</h1><p><a href='/'>Retour</a></p>";
            return;
        }

        require __DIR__ . '/../Views/trajets/show.php';
    }
}
