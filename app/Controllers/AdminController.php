<?php

declare(strict_types=1);

class AdminController
{
    public function index(): void
    {
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::requireAdmin();

        // ✅ Récupérer les trajets
        require_once __DIR__ . '/../Models/Trajet.php';
        $trajets = Trajet::allWithAgences();

        // ✅ Afficher la vue avec $trajets
        require __DIR__ . '/../Views/admin/index.php';
    }
}
