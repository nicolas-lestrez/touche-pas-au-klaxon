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
$isAdmin = ($user['role'] ?? '') === 'ADMIN';
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Touche pas au klaxon — Trajets</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
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
                            <a class="nav-pill-btn" href="/admin/users">Utilisateurs</a>
                            <a class="nav-pill-btn" href="/admin/agences">Agences</a>


                            <?php if ($isAdmin): ?>
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

    <main class="container">

        <?php if (!$user): ?>
            <h1 class="mb-3">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</h1>
        <?php else: ?>
            <h1 class="mb-3">Trajets proposés</h1>
        <?php endif; ?>

        <div class="table-responsive rounded-4 overflow-hidden border">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Départ</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Heure</th>
                        <th class="text-center">Destination</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Heure</th>
                        <th class="text-center">Places</th>

                        <?php if ($user): ?>
                            <th class="text-center">Détails</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $colspan = $user ? 8 : 7; ?>

                    <?php if (empty($trajets)): ?>
                        <tr>
                            <td colspan="<?= $colspan ?>" class="text-center py-4">
                                Aucun trajet trouvé.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($trajets as $t): ?>
                            <tr>
                                <td class="text-center"><?= e($t['ville_depart']) ?></td>
                                <td class="text-center"><?= e(formatDate($t['gdh_depart'])) ?></td>
                                <td class="text-center"><?= e(formatHeure($t['gdh_depart'])) ?></td>
                                <td class="text-center"><?= e($t['ville_arrivee']) ?></td>
                                <td class="text-center"><?= e(formatDate($t['gdh_arrivee'])) ?></td>
                                <td class="text-center"><?= e(formatHeure($t['gdh_arrivee'])) ?></td>
                                <td class="text-center"><?= e((string)$t['nb_places_disponibles']) ?></td>

                                <?php if ($user): ?>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center gap-2">

                                            <!-- 👁️ MODALE CONTACT -->
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-dark"
                                                title="Voir le contact"
                                                data-bs-toggle="modal"
                                                data-bs-target="#contactModal"
                                                data-auteur="<?= e(trim(($t['contact_prenom'] ?? '') . ' ' . ($t['contact_nom'] ?? ''))) ?>"
                                                data-telephone="<?= e($t['contact_telephone'] ?? '') ?>"
                                                data-email="<?= e($t['contact_email'] ?? '') ?>"
                                                data-places-total="<?= e((string)($t['nb_places_total'] ?? '')) ?>">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            <!-- 📓 Voir la page -->
                                            <a class="btn btn-sm btn-outline-dark"
                                                title="Voir la page"
                                                href="/trajets/<?= e((string)$t['id_trajet']) ?>">
                                                <i class="bi bi-journal-text"></i>
                                            </a>

                                            <!-- 🗑 Supprimer (ADMIN seulement) -->
                                            <?php if ($isAdmin): ?>
                                                <form method="post" action="/admin/trajets/delete"
                                                    onsubmit="return confirm('Supprimer ce trajet ?');"
                                                    class="d-inline m-0 p-0">
                                                    <input type="hidden" name="id_trajet" value="<?= e((string)$t['id_trajet']) ?>">
                                                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Supprimer">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>

    <?php if ($user): ?>
        <!-- ✅ MODALE CONTACT -->
        <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-3"><strong>Auteur :</strong> <span id="contactAuteur"></span></p>
                        <p class="mb-3"><strong>Téléphone :</strong> <span id="contactTelephone"></span></p>
                        <p class="mb-3"><strong>Email :</strong> <span id="contactEmail"></span></p>
                        <p class="mb-0"><strong>Nombre total de places :</strong> <span id="contactPlacesTotal"></span></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <footer style="margin-top: 40px; text-align: center; font-size: 0.9rem; color: #6c757d;">
        Touche pas au klaxon - Copyright <?= date('Y') ?>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if ($user): ?>
        <script>
            const modal = document.getElementById('contactModal');

            modal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;

                document.getElementById('contactAuteur').textContent = btn.dataset.auteur || '-';
                document.getElementById('contactTelephone').textContent = btn.dataset.telephone || '-';
                document.getElementById('contactEmail').textContent = btn.dataset.email || '-';
                document.getElementById('contactPlacesTotal').textContent = btn.dataset.placesTotal || '-';
            });
        </script>
    <?php endif; ?>

</body>

</html>