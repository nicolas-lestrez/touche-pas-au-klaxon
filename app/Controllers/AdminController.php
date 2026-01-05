<?php

declare(strict_types=1);

class AdminController
{
    public function index(): void
    {
        // Vérifie que l’utilisateur est bien ADMIN
        require_once __DIR__ . '/../Core/Auth.php';
        Auth::requireAdmin();

        // Affiche la vue admin
        require __DIR__ . '/../Views/admin/index.php';
    }
}
