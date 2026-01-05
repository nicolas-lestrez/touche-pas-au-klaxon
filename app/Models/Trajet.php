<?php

declare(strict_types=1);

class Trajet
{
    /**
     * Récupère la liste des trajets avec :
     * - ville départ
     * - ville arrivée
     * - auteur (nom/prenom/email/téléphone)
     * - nb places
     * - dates/heures
     */
    public static function all(): array
    {
        $pdo = Database::getConnection();

        $sql = "
            SELECT
                t.id_trajet,
                t.gdh_depart,
                t.gdh_arrivee,
                t.nb_places_total,
                t.nb_places_disponibles,

                a_dep.ville AS ville_depart,
                a_arr.ville AS ville_arrivee,

                u.nom AS auteur_nom,
                u.prenom AS auteur_prenom,
                u.email AS auteur_email,
                u.telephone AS auteur_telephone
            FROM TRAJET t
            INNER JOIN AGENCE a_dep ON a_dep.id_agence = t.id_agence_depart
            INNER JOIN AGENCE a_arr ON a_arr.id_agence = t.id_agence_arrivee
            INNER JOIN UTILISATEUR u ON u.id_utilisateur = t.id_auteur
            ORDER BY t.gdh_depart ASC
        ";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
