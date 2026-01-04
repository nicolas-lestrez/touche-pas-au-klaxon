<?php

declare(strict_types=1);

require_once __DIR__ . '/../Models/Database.php';

final class DbTestController
{
    public function index(): void
    {
        $nbUsers = null;
        $error = null;

        try {
            $pdo = Database::getConnection();

            // Petite requête simple pour tester
            $stmt = $pdo->query('SELECT COUNT(*) AS nb FROM UTILISATEUR');
            $result = $stmt->fetch();
            $nbUsers = (int) ($result['nb'] ?? 0);
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }

        require __DIR__ . '/../Views/db_test.php';
    }
}
