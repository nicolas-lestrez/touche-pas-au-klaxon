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
    <title>Détails trajet #<?= e((string)$trajet['id_trajet']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <div class="container" style="max-width: 850px;">

        <h1 class="mb-3">Détails du trajet #<?= e((string)$trajet['id_trajet']) ?></h1>

        <p><a href="/">← Retour à la liste</a></p>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3">Trajet</h5>

                <p class="mb-1"><strong>Départ :</strong> <?= e($trajet['ville_depart']) ?></p>
                <p class="mb-1"><strong>Date/heure départ :</strong> <?= e(formatDate($trajet['gdh_depart'])) ?> à <?= e(formatHeure($trajet['gdh_depart'])) ?></p>

                <hr>

                <p class="mb-1"><strong>Arrivée :</strong> <?= e($trajet['ville_arrivee']) ?></p>
                <p class="mb-1"><strong>Date/heure arrivée :</strong> <?= e(formatDate($trajet['gdh_arrivee'])) ?> à <?= e(formatHeure($trajet['gdh_arrivee'])) ?></p>

                <hr>

                <p class="mb-0">
                    <strong>Places :</strong>
                    <?= e((string)$trajet['nb_places_disponibles']) ?> / <?= e((string)$trajet['nb_places_total']) ?>
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Contact</h5>

                <?php if ($user): ?>
                    <p class="mb-1"><strong>Nom :</strong> <?= e($trajet['contact_prenom'] . ' ' . $trajet['contact_nom']) ?></p>
                    <p class="mb-1"><strong>Téléphone :</strong> <?= e($trajet['contact_telephone']) ?></p>
                    <p class="mb-0"><strong>Email :</strong> <?= e($trajet['contact_email']) ?></p>
                <?php else: ?>
                    <p class="mb-0 text-muted">Connecte-toi pour voir les coordonnées du contact.</p>
                    <p class="mb-0"><a href="/login">Se connecter</a></p>
                <?php endif; ?>
            </div>
        </div>

    </div>

</body>

</html>