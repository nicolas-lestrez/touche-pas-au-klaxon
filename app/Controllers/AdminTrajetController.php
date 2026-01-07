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

    public function delete(): void
    {
        Auth::requireAdmin();

        if (!isset($_POST['id_trajet'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'ID manquant'];
            header('Location: /admin');
            exit;
        }

        $id = (int)$_POST['id_trajet'];

        require_once __DIR__ . '/../Models/Trajet.php';
        Trajet::deleteById($id);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Trajet supprimé ✅'
        ];

        header('Location: /admin');
        exit;
    }

    public function edit(int $id): void
    {
        Auth::requireAdmin();

        require_once __DIR__ . '/../Models/Trajet.php';

        $trajet = Trajet::findByIdForEdit($id);

        if (!$trajet) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Trajet introuvable'];
            header('Location: /admin');
            exit;
        }

        // Vue du formulaire d'édition
        require __DIR__ . '/../Views/admin/trajets/edit.php';
    }

    public function update(int $id): void
    {
        Auth::requireAdmin();

        require_once __DIR__ . '/../Models/Trajet.php';

        // 1) Nettoyage / formatage dates (datetime-local -> MySQL DATETIME)
        $gdhDepart  = str_replace('T', ' ', $_POST['gdh_depart'] ?? '') . ':00';
        $gdhArrivee = str_replace('T', ' ', $_POST['gdh_arrivee'] ?? '') . ':00';

        // 2) Cast des nombres
        $nbTotal = (int) ($_POST['nb_places_total'] ?? 0);
        $idAgenceDepart = (int) ($_POST['id_agence_depart'] ?? 0);
        $idAgenceArrivee = (int) ($_POST['id_agence_arrivee'] ?? 0);

        if ($nbTotal < 1 || $idAgenceDepart < 1 || $idAgenceArrivee < 1) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Champs invalides'];
            header("Location: /admin/trajets/$id/edit");
            exit;
        }

        // On récupère l'ancien trajet pour gérer les places dispo proprement
        $old = Trajet::findByIdForEdit($id);
        if (!$old) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Trajet introuvable'];
            header('Location: /admin');
            exit;
        }

        // Règle simple (sans système de réservation) :
        // - si tu réduis le total, les places dispo ne peuvent pas dépasser le total
        $oldDispo = (int)($old['nb_places_disponibles'] ?? 0);
        $newDispo = min($oldDispo, $nbTotal);

        Trajet::updateById($id, [
            'gdh_depart' => $gdhDepart,
            'gdh_arrivee' => $gdhArrivee,
            'nb_places_total' => $nbTotal,
            'nb_places_disponibles' => $newDispo,
            'id_agence_depart' => $idAgenceDepart,
            'id_agence_arrivee' => $idAgenceArrivee,
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Trajet modifié avec succès ✅'
        ];

        header('Location: /admin');
        exit;
    }
}
