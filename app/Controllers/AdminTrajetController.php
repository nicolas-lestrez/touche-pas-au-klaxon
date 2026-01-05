<?php

declare(strict_types=1);

require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Models/Database.php';

class AdminTrajetController
{
    public function store(): void
    {
        Auth::requireAdmin();

        $pdo = Database::getConnection();

        // 1) Nettoyage / formatage dates (datetime-local -> MySQL DATETIME)
        $gdhDepart  = str_replace('T', ' ', $_POST['gdh_depart']) . ':00';
        $gdhArrivee = str_replace('T', ' ', $_POST['gdh_arrivee']) . ':00';

        // 2) Cast des nombres
        $nbTotal = (int) $_POST['nb_places_total'];
        $idAgenceDepart = (int) $_POST['id_agence_depart'];
        $idAgenceArrivee = (int) $_POST['id_agence_arrivee'];

        // 3) ID de l'admin connecté
        $idAuteur = (int) ($_SESSION['user']['id_utilisateur'] ?? $_SESSION['user']['id'] ?? 0);

        // Sécurité minimale
        if ($idAuteur <= 0) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => "Erreur : utilisateur non trouvé en session."
            ];
            header('Location: /admin');
            exit;
        }

        $sql = "
        INSERT INTO TRAJET (
            gdh_depart,
            gdh_arrivee,
            nb_places_total,
            nb_places_disponibles,
            id_agence_depart,
            id_agence_arrivee,
            id_auteur,
            id_contact
        ) VALUES (
            :gdh_depart,
            :gdh_arrivee,
            :nb_places_total,
            :nb_places_disponibles,
            :id_agence_depart,
            :id_agence_arrivee,
            :id_auteur,
            :id_contact
        )
    ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'gdh_depart' => $gdhDepart,
            'gdh_arrivee' => $gdhArrivee,
            'nb_places_total' => $nbTotal,
            'nb_places_disponibles' => $nbTotal,
            'id_agence_depart' => $idAgenceDepart,
            'id_agence_arrivee' => $idAgenceArrivee,
            'id_auteur' => $idAuteur,
            'id_contact' => $idAuteur, // pour l'instant : contact = auteur
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Trajet créé avec succès ✅'
        ];

        header('Location: /admin');
        exit;
    }
}
