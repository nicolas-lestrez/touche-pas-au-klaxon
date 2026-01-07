<?php

declare(strict_types=1);

require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Utilisateur.php';

class AdminUserController
{
    public function index(): void
    {
        Auth::requireAdmin();

        $users = Utilisateur::allNonAdmin();

        require __DIR__ . '/../Views/admin/users/index.php';
    }
}
