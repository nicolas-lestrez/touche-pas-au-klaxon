<?php

declare(strict_types=1);

function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        .box {
            width: 420px;
            max-width: 100%;
            padding: 18px;
            border: 2px solid #2f353a;
            border-radius: 12px;
        }

        label {
            display: block;
            margin-top: 12px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
        }

        button {
            margin-top: 14px;
            padding: 10px 14px;
        }

        .flash {
            margin-bottom: 12px;
            padding: 10px;
            border-radius: 8px;
        }

        .success {
            background: #e6ffed;
            border: 1px solid #1f883d;
        }

        .error {
            background: #ffeef0;
            border: 1px solid #cf222e;
        }

        a {
            color: #2a4bd7;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h1>Connexion</h1>

    <?php if ($flash): ?>
        <div class="flash <?= e($flash['type']) ?>">
            <?= e($flash['message']) ?>
        </div>
    <?php endif; ?>

    <div class="box">
        <form method="POST" action="/login">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Mot de passe</label>
            <input type="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>

    <p style="margin-top:14px;"><a href="/">← Retour accueil</a></p>

</body>

</html>