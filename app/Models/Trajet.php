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

    public static function availableUpcoming(): array
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
            a2.ville AS ville_arrivee,

            u.prenom AS contact_prenom,
            u.nom AS contact_nom,
            u.telephone AS contact_telephone,
            u.email AS contact_email

        FROM TRAJET t
        JOIN AGENCE a1 ON a1.id_agence = t.id_agence_depart
        JOIN AGENCE a2 ON a2.id_agence = t.id_agence_arrivee
        JOIN UTILISATEUR u ON u.id_utilisateur = t.id_contact

        WHERE t.gdh_depart >= NOW()
          AND t.nb_places_disponibles > 0
        ORDER BY t.gdh_depart ASC
    ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array
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
            a2.ville AS ville_arrivee,
            u.prenom AS contact_prenom,
            u.nom AS contact_nom,
            u.telephone AS contact_telephone,
            u.email AS contact_email
        FROM TRAJET t
        JOIN AGENCE a1 ON a1.id_agence = t.id_agence_depart
        JOIN AGENCE a2 ON a2.id_agence = t.id_agence_arrivee
        JOIN UTILISATEUR u ON u.id_utilisateur = t.id_contact
        WHERE t.id_trajet = :id
        LIMIT 1
    ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }



    public static function deleteById(int $id): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM TRAJET WHERE id_trajet = :id");
        $stmt->execute(['id' => $id]);
    }

    public static function findWithAgencesById(int $id): ?array
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
            a2.ville AS ville_arrivee,

            -- ✅ Contact (lié au trajet)
            u.nom    AS contact_nom,
            u.prenom AS contact_prenom,
            u.telephone AS contact_telephone,
            u.email  AS contact_email

        FROM TRAJET t
        JOIN AGENCE a1 ON a1.id_agence = t.id_agence_depart
        JOIN AGENCE a2 ON a2.id_agence = t.id_agence_arrivee

        -- ✅ On récupère le contact via id_contact
        LEFT JOIN UTILISATEUR u ON u.id_utilisateur = t.id_contact

        WHERE t.id_trajet = :id
        LIMIT 1
    ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }
}
