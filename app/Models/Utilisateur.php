<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class Utilisateur
{
    /**
     * Retourne tous les utilisateurs sauf les ADMIN
     */
    public static function allNonAdmin(): array
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT
                id_utilisateur,
                prenom,
                nom,
                email,
                telephone,
                role
            FROM UTILISATEUR
            WHERE role <> 'ADMIN'
            ORDER BY nom ASC, prenom ASC
        ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
