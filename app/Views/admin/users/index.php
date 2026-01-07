<?php

declare(strict_types=1);

function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

$user = $_SESSION['user'] ?? null;

// ✅ Ici on veut le menu complet (Utilisateurs / Agences / Trajets)
$isTrajetsPage = false;
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Admin — Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- ✅ HEADER -->
    <header class="w-100 border border-2 rounded-4 p-3 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

            <a href="/" class="fw-semibold fs-5 text-decoration-none text-dark">
                Touche pas au klaxon
            </a>

            <?php if (!$user): ?>
                <a href="/login" class="btn btn-dark rounded-pill px-4">Connexion</a>
            <?php else: ?>
                <div class="d-flex align-items-center flex-wrap gap-3">

                    <div class="d-flex gap-2">
                        <a href="/admin/users" class="btn btn-secondary rounded-pill px-3">Utilisateurs</a>
                        <a href="/admin/agences" class="btn btn-secondary rounded-pill px-3">Agences</a>
                        <a href="/admin" class="btn btn-secondary rounded-pill px-3">Trajets</a>
                    </div>

                    <div class="text-nowrap">
                        Bonjour <?= e(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?>
                    </div>

                    <a href="/logout" class="btn btn-dark rounded-pill px-4">Déconnexion</a>
                </div>
            <?php endif; ?>

        </div>
    </header>

    <main class="container-fluid px-0">
        <h1 class="mb-3">Utilisateurs (admin)</h1>

        <p class="mb-2">
            <a href="/admin" class="text-decoration-none">← Retour admin</a>
        </p>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Rôle</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5">Aucun utilisateur.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= e($u['nom'] ?? '') ?></td>
                            <td><?= e($u['prenom'] ?? '') ?></td>
                            <td><?= e($u['email'] ?? '') ?></td>
                            <td><?= e($u['telephone'] ?? '') ?></td>
                            <td><?= e($u['role'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <footer style="margin-top: 40px; text-align: center; font-size: 0.9rem; color: #6c757d;">
        Touche pas au klaxon - Copyright <?= date('Y') ?>
    </footer>

</body>

</html>