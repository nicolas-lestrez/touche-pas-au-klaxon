<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

class Trajet
{
    public static function allWithAgences(): array
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT 
                t.id_trajet,
                t.gdh_depart,
                t.gdh_arrivee,
                t.nb_places_total,
                t.nb_places_disponibles,
                a1.ville AS ville_depart,
                a2.ville AS ville_arrivee
            FROM TRAJET t
            JOIN AGENCE a1 ON a1.id_agence = t.id_agence_depart
            JOIN AGENCE a2 ON a2.id_agence = t.id_agence_arrivee
            ORDER BY t.gdh_depart ASC
        ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteById(int $id): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM TRAJET WHERE id_trajet = :id");
        $stmt->execute(['id' => $id]);
    }
}
