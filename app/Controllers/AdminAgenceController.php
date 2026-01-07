<?php

declare(strict_types=1);

require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Agence.php';

class AdminAgenceController
{
    public function index(): void
    {
        Auth::requireAdmin();

        $agences = Agence::all();

        require __DIR__ . '/../Views/admin/agences/index.php';
    }
}
