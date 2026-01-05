<?php

declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$user = $_SESSION['user'] ?? null;
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Espace admin — Touche pas au klaxon</title>
</head>

<body>

    <h1>Espace admin</h1>

    <?php if ($flash): ?>
        <p style="color: <?= $flash['type'] === 'success' ? 'green' : 'red' ?>;">
            <?= e($flash['message']) ?>
        </p>
    <?php endif; ?>

    <p>
        Connecté : <strong><?= $user ? e($user['prenom'] . ' ' . $user['nom']) : '—' ?></strong>
        (<?= $user ? e($user['role']) : '—' ?>)
    </p>

    <p><a href="/">← Retour à l’accueil</a></p>

    <hr>

    <p>
        <a href="/admin/trajets/create">➕ Créer un trajet</a>
    </p>


</body>

</html>
