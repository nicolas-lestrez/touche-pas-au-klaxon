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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .nav-pill-btn {
            background: #6c757d;
            color: #fff !important;
            border-radius: 12px;
            padding: 8px 14px;
            text-decoration: none;
            display: inline-block;
        }

        .nav-pill-btn:hover {
            opacity: .9;
            text-decoration: none;
        }

        table {
            width: 100%;
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
    </style>
</head>

<body>

    <!-- ✅ HEADER FULL WIDTH -->
    <header class="w-100 border-bottom border-2 rounded-4 py-3 mb-4">
        <div class="container">

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                <!-- LOGO / TITLE -->
                <a href="/" class="fw-semibold fs-5 text-decoration-none text-dark">
                    Touche pas au klaxon
                </a>


                <?php if (!$user): ?>
                    <!-- VISITEUR -->
                    <a href="/login" class="btn btn-dark rounded-pill px-4">
                        Connexion
                    </a>
                <?php else: ?>
                    <!-- CONNECTÉ -->
                    <div class="d-flex align-items-center flex-wrap gap-3">

                        <nav class="d-flex align-items-center gap-2">
                            <a class="nav-pill-btn" href="#">Utilisateurs</a>
                            <a class="nav-pill-btn" href="#">Agences</a>

                            <?php if (($user['role'] ?? '') === 'ADMIN'): ?>
                                <a class="nav-pill-btn" href="/admin">Trajets</a>
                            <?php else: ?>
                                <a class="nav-pill-btn" href="/trajets">Trajets</a>
                            <?php endif; ?>
                        </nav>

                        <div class="text-nowrap">
                            Bonjour <?= e($user['prenom'] . ' ' . $user['nom']) ?>
                        </div>

                        <a href="/logout" class="btn btn-dark rounded-pill px-4">
                            Déconnexion
                        </a>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </header>

    <!-- ✅ CONTENU CENTRÉ -->
    <main class="container">

        <h1 class="mb-3">Trajets proposés</h1>

        <p class="text-muted">Liste des trajets présents en base.</p>

        <table class="table table-bordered align-middle">
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
                            <td>
                                <button
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#trajetDetailsModal"
                                    data-id="<?= e((string)$t['id_trajet']) ?>"
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
                                    <a href="/trajets/<?= e((string)$t['id_trajet']) ?>">Voir la page</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </main>

    <!-- MODALE -->
    <div class="modal fade" id="trajetDetailsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Détails du trajet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p><strong>Trajet #</strong> <span id="detailId"></span></p>
                    <hr>
                    <p><strong>Départ :</strong> <span id="detailDepart"></span></p>
                    <p><strong>Date départ :</strong> <span id="detailDateDepart"></span></p>
                    <p><strong>Heure départ :</strong> <span id="detailHeureDepart"></span></p>
                    <hr>
                    <p><strong>Arrivée :</strong> <span id="detailArrivee"></span></p>
                    <p><strong>Date arrivée :</strong> <span id="detailDateArrivee"></span></p>
                    <p><strong>Heure arrivée :</strong> <span id="detailHeureArrivee"></span></p>
                    <hr>
                    <p><strong>Places disponibles :</strong> <span id="detailPlaces"></span></p>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const modal = document.getElementById('trajetDetailsModal');
        modal.addEventListener('show.bs.modal', function(event) {
            const btn = event.relatedTarget;

            detailId.textContent = btn.dataset.id;
            detailDepart.textContent = btn.dataset.depart;
            detailArrivee.textContent = btn.dataset.arrivee;
            detailDateDepart.textContent = btn.dataset.dateDepart;
            detailHeureDepart.textContent = btn.dataset.heureDepart;
            detailDateArrivee.textContent = btn.dataset.dateArrivee;
            detailHeureArrivee.textContent = btn.dataset.heureArrivee;
            detailPlaces.textContent = btn.dataset.places;
        });
    </script>

</body>

</html>