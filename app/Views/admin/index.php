<?php

declare(strict_types=1);

function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}
function formatDate(string $dt): string
{
    return date('d/m/Y', strtotime($dt));
}
function formatHeure(string $dt): string
{
    return date('H:i', strtotime($dt));
}

$user = $_SESSION['user'] ?? null;

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Admin — Trajets</title>

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-3">

    <h1 class="mb-3">Espace admin</h1>

    <p>
        Connecté : <strong><?= e(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?></strong>
        (<?= e($user['role'] ?? '') ?>)
    </p>

    <p><a href="/">← Retour à l’accueil</a></p>

    <?php if ($flash): ?>
        <div class="alert alert-success py-2">
            <?= e($flash['message']) ?>
        </div>
    <?php endif; ?>

    <hr>

    <p><a class="btn btn-success btn-sm" href="/admin/trajets/create">➕ Créer un trajet</a></p>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Départ</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Arrivée</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places dispo</th>
                <th>Détails</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($trajets)): ?>
                <tr>
                    <td colspan="9">Aucun trajet.</td>
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

                        <!-- ✅ Bouton Détails + data-* -->
                        <td>
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#trajetDetailsModal"
                                data-depart="<?= e($t['ville_depart']) ?>"
                                data-arrivee="<?= e($t['ville_arrivee']) ?>"
                                data-date-depart="<?= e(formatDate($t['gdh_depart'])) ?>"
                                data-heure-depart="<?= e(formatHeure($t['gdh_depart'])) ?>"
                                data-date-arrivee="<?= e(formatDate($t['gdh_arrivee'])) ?>"
                                data-heure-arrivee="<?= e(formatHeure($t['gdh_arrivee'])) ?>"
                                data-places="<?= e((string)$t['nb_places_disponibles']) ?>"
                                data-id="<?= e((string)$t['id_trajet']) ?>">
                                Détails
                            </button>
                        </td>

                        <td>
                            <form method="post" action="/admin/trajets/delete" onsubmit="return confirm('Supprimer ce trajet ?');">
                                <input type="hidden" name="id_trajet" value="<?= e((string)$t['id_trajet']) ?>">
                                <button class="btn btn-danger btn-sm" type="submit">🗑 Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- ✅ MODALE DÉTAILS -->
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
                    <p class="mb-0"><strong>Places disponibles :</strong> <span id="detailPlaces"></span></pест
                            </div>

                </div>
            </div>
        </div>

        <!-- ✅ Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- ✅ JS : remplit la modale depuis data-* -->
        <script>
            document.getElementById('trajetDetailsModal').addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                document.getElementById('detailId').textContent = button.dataset.id;

                document.getElementById('detailDepart').textContent = button.dataset.depart;
                document.getElementById('detailDateDepart').textContent = button.dataset.dateDepart;
                document.getElementById('detailHeureDepart').textContent = button.dataset.heureDepart;

                document.getElementById('detailArrivee').textContent = button.dataset.arrivee;
                document.getElementById('detailDateArrivee').textContent = button.dataset.dateArrivee;
                document.getElementById('detailHeureArrivee').textContent = button.dataset.heureArrivee;

                document.getElementById('detailPlaces').textContent = button.dataset.places;
            });
        </script>

</body>

</html>