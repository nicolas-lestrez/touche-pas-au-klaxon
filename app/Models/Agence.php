<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class Agence
{
    public static function all(): array
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT
                id_agence,
                ville
            FROM AGENCE
            ORDER BY ville ASC
        ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
