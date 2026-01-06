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
</head>

<body>

    <h1>Espace admin</h1>

    <p>
        Connecté : <strong><?= e(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?></strong>
        (<?= e($user['role'] ?? '') ?>)
    </p>

    <p><a href="/">← Retour à l’accueil</a></p>

    <?php if ($flash): ?>
        <p style="color: green;"><?= e($flash['message']) ?></p>
    <?php endif; ?>

    <hr>

    <p><a href="/admin/trajets/create">➕ Créer un trajet</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Départ</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Arrivée</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places dispo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($trajets)): ?>
                <tr>
                    <td colspan="8">Aucun trajet.</td>
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
                            <form method="post" action="/admin/trajets/delete" onsubmit="return confirm('Supprimer ce trajet ?');">
                                <input type="hidden" name="id_trajet" value="<?= e((string)$t['id_trajet']) ?>">
                                <button type="submit">🗑 Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>