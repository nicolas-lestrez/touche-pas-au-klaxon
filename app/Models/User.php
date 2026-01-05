<?php

declare(strict_types=1);

class User
{
    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT * FROM UTILISATEUR WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}
