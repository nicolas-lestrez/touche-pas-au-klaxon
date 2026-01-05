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
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Touche pas au klaxon — Trajets</title>
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


    <?php $user = $_SESSION['user'] ?? null; ?>

    <p>
        <?php if ($user): ?>
            Connecté : <strong><?= e($user['prenom'] . ' ' . $user['nom']) ?></strong>
            (<?= e($user['role']) ?>)

            <?php if ($user['role'] === 'ADMIN'): ?>
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
            </tr>
        </thead>
        <tbody>
            <?php if (empty($trajets)): ?>
                <tr>
                    <td colspan="7">Aucun trajet trouvé.</td>
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
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>