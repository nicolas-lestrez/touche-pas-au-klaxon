<?php

declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function formatDate(string $datetime): string
{
    return date('d/m/Y', strtotime($datetime));
}

function formatHeure(string $datetime): string
{
    return date('H:i', strtotime($datetime));
}

$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Touche pas au klaxon — Trajets</title>

    <!-- ✅ Étape 2A : Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 16px;
        }

        table {
            border-collapse: collapse;
            width: 900px;
            max-width: 100%;
        }

        thead th {
            background: #2f353a;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        tbody td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f7f7f7;
        }

        .topbar {
            margin-bottom: 20px;
            padding: 12px 16px;
            border: 2px solid #2f353a;
            border-radius: 12px;
            width: 900px;
            max-width: 100%;
        }

        .muted {
            color: #666;
            margin-bottom: 14px;
        }

        a {
            color: #2a4bd7;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <strong>Touche pas au klaxon</strong>
    </div>

    <h1>Trajets proposés</h1>

    <p>
        <?php if ($user): ?>
            Connecté : <strong><?= e($user['prenom'] . ' ' . $user['nom']) ?></strong>
            (<?= e($user['role']) ?>)

            <?php if (($user['role'] ?? '') === 'ADMIN'): ?>
                — <a href="/admin">Espace admin</a>
            <?php endif; ?>

            — <a href="/logout">Se déconnecter</a>
        <?php else: ?>
            <a href="/login">Se connecter</a>
        <?php endif; ?>
    </p>

    <p class="muted">Liste des trajets présents en base.</p>

    <table>
        <thead>
            <tr>
                <th>Départ</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places</th>
                <th>Détails</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($trajets)): ?>
                <tr>
                    <td colspan="8">Aucun trajet trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($trajets as $t): ?>
                    <tr>
                        <td><?= e($t['ville_depart']) ?></td>
                        <td><?= e(formatDate($t['gdh_depart'])) ?></td>
                        <td><?= e(formatHeure($t['gdh_depart'])) ?></td>
                        <td><?= e($t['ville_arrivee']) ?></td>
                        <td><?= e(formatDate($t['gdh_arrivee'])) ?></td>
                        <td><?= e(formatHeure($t['gdh_arrivee'])) ?></td>
                        <td><?= e((string)$t['nb_places_disponibles']) ?></td>

                        <!-- ✅ Étape 2B : bouton Détails + data-* pour remplir la modale -->
                        <td>
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#trajetDetailsModal"
                                data-id="<?= e((string)($t['id_trajet'] ?? '')) ?>"
                                data-depart="<?= e($t['ville_depart']) ?>"
                                data-arrivee="<?= e($t['ville_arrivee']) ?>"
                                data-date-depart="<?= e(formatDate($t['gdh_depart'])) ?>"
                                data-heure-depart="<?= e(formatHeure($t['gdh_depart'])) ?>"
                                data-date-arrivee="<?= e(formatDate($t['gdh_arrivee'])) ?>"
                                data-heure-arrivee="<?= e(formatHeure($t['gdh_arrivee'])) ?>"
                                data-places="<?= e((string)$t['nb_places_disponibles']) ?>">
                                Détails
                            </button>

                            <div class="mt-1">
                                <a href="/trajets/<?= e((string)$t['id_trajet']) ?>">
                                    Voir la page
                                </a>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- ✅ Étape 2C : la modale Bootstrap -->
    <div class="modal fade" id="trajetDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Détails du trajet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-1"><strong>Trajet #</strong> <span id="detailId"></span></p>
                    <hr>

                    <p class="mb-1"><strong>Départ :</strong> <span id="detailDepart"></span></p>
                    <p class="mb-1"><strong>Date départ :</strong> <span id="detailDateDepart"></span></p>
                    <p class="mb-3"><strong>Heure départ :</strong> <span id="detailHeureDepart"></span></p>

                    <p class="mb-1"><strong>Arrivée :</strong> <span id="detailArrivee"></span></p>
                    <p class="mb-1"><strong>Date arrivée :</strong> <span id="detailDateArrivee"></span></p>
                    <p class="mb-3"><strong>Heure arrivée :</strong> <span id="detailHeureArrivee"></span></p>

                    <hr>
                    <p class="mb-0"><strong>Places disponibles :</strong> <span id="detailPlaces"></span></p>
                </div>

            </div>
        </div>
    </div>

    <!-- ✅ Étape 2D : Bootstrap JS (obligatoire pour la modale) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Étape 2E : JS qui remplit la modale -->
    <script>
        const modal = document.getElementById('trajetDetailsModal');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            document.getElementById('detailId').textContent = button.dataset.id || '-';
            document.getElementById('detailDepart').textContent = button.dataset.depart || '';
            document.getElementById('detailArrivee').textContent = button.dataset.arrivee || '';

            document.getElementById('detailDateDepart').textContent = button.dataset.dateDepart || '';
            document.getElementById('detailHeureDepart').textContent = button.dataset.heureDepart || '';

            document.getElementById('detailDateArrivee').textContent = button.dataset.dateArrivee || '';
            document.getElementById('detailHeureArrivee').textContent = button.dataset.heureArrivee || '';

            document.getElementById('detailPlaces').textContent = button.dataset.places || '0';
        });
    </script>

</body>

</html>