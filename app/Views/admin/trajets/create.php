<?php

declare(strict_types=1);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Créer un trajet</title>
</head>

<body>

    <h1>Créer un trajet</h1>

    <?php if ($flash): ?>
        <p style="color: green;">
            <?= htmlspecialchars($flash['message']) ?>
        </p>
    <?php endif; ?>

    <form method="post" action="/admin/trajets/store">

        <label>Date & heure de départ</label><br>
        <input type="datetime-local" name="gdh_depart" required><br><br>

        <label>Date & heure d’arrivée</label><br>
        <input type="datetime-local" name="gdh_arrivee" required><br><br>

        <label>Nombre de places total</label><br>
        <input type="number" name="nb_places_total" min="1" required><br><br>

        <label>Agence de départ (ID)</label><br>
        <input type="number" name="id_agence_depart" required><br><br>

        <label>Agence d’arrivée (ID)</label><br>
        <input type="number" name="id_agence_arrivee" required><br><br>

        <button type="submit">Créer le trajet</button>

    </form>

    <p><a href="/admin">← Retour admin</a></p>

    <footer style="margin-top: 40px; text-align: center; font-size: 0.9rem; color: #6c757d;">
        Touche pas au klaxon - Copyright <?= date('Y') ?>
    </footer>

</body>

</html>
