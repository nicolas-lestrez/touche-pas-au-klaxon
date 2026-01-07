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
$isLoggedIn = !empty($user);
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails trajet #<?= e((string)$trajet['id_trajet']) ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <main class="container py-4" style="max-width: 920px;">

        <!-- Top title + back button -->
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-3">
            <div>
                <h1 class="h2 mb-1">Détails du trajet #<?= e((string)$trajet['id_trajet']) ?></h1>
                <p class="text-muted mb-0">Informations du trajet et du contact.</p>
            </div>

            <a href="/" class="btn btn-outline-dark rounded-pill px-4">
                ← Retour à la liste
            </a>
        </div>

        <div class="row g-3">

            <!-- Card Trajet -->
            <div class="col-12 col-lg-7">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h5 mb-0">Trajet</h2>

                            <!-- Badge places -->
                            <span class="badge text-bg-dark rounded-pill px-3 py-2">
                                Places : <?= e((string)$trajet['nb_places_disponibles']) ?> / <?= e((string)$trajet['nb_places_total']) ?>
                            </span>
                        </div>

                        <div class="border rounded-4 p-3 mb-3 bg-white">
                            <div class="fw-semibold mb-1">Départ</div>
                            <div><?= e($trajet['ville_depart']) ?></div>
                            <div class="text-muted small">
                                <?= e(formatDate($trajet['gdh_depart'])) ?> à <?= e(formatHeure($trajet['gdh_depart'])) ?>
                            </div>
                        </div>

                        <div class="border rounded-4 p-3 bg-white">
                            <div class="fw-semibold mb-1">Arrivée</div>
                            <div><?= e($trajet['ville_arrivee']) ?></div>
                            <div class="text-muted small">
                                <?= e(formatDate($trajet['gdh_arrivee'])) ?> à <?= e(formatHeure($trajet['gdh_arrivee'])) ?>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex flex-wrap gap-2">
                            <?php if (!$isLoggedIn): ?>
                                <a href="/login" class="btn btn-dark rounded-pill px-4">
                                    Se connecter pour voir le contact
                                </a>
                            <?php else: ?>
                                <span class="badge text-bg-success rounded-pill px-3 py-2">
                                    Contact visible ✅
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Contact -->
            <div class="col-12 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-3">Contact</h2>

                        <?php if ($isLoggedIn): ?>
                            <div class="mb-2">
                                <div class="text-muted small">Nom</div>
                                <div class="fw-semibold">
                                    <?= e(($trajet['contact_prenom'] ?? '') . ' ' . ($trajet['contact_nom'] ?? '')) ?>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="text-muted small">Téléphone</div>
                                <div class="fw-semibold">
                                    <?= e((string)($trajet['contact_telephone'] ?? '')) ?>
                                </div>
                            </div>

                            <div>
                                <div class="text-muted small">Email</div>
                                <div class="fw-semibold">
                                    <?= e((string)($trajet['contact_email'] ?? '')) ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0 rounded-4">
                                <div class="fw-semibold mb-1">Coordonnées masquées</div>
                                <div class="small">
                                    Connecte-toi pour voir le téléphone et l’email du contact.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        <footer class="text-center text-muted small mt-4">
            Touche pas au klaxon - Copyright <?= date('Y') ?>
        </footer>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>