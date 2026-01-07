<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Test DB - Touche pas au klaxon</title>
</head>

<body>
    <h1>Test connexion DB</h1>

    <?php if (!empty($error)) : ?>
        <p>Erreur de connexion ou de requete :</p>
        <pre><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></pre>
    <?php else : ?>
        <p>Connexion PDO OK ✅</p>
        <p>Nombre d'utilisateurs en base : <strong><?= $nbUsers ?></strong></p>
    <?php endif; ?>

    <p><a href="./">Retour accueil</a></p>

    <footer style="margin-top: 40px; text-align: center; font-size: 0.9rem; color: #6c757d;">
        Touche pas au klaxon - Copyright <?= date('Y') ?>
    </footer>
</body>

</html>
