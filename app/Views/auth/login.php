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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Page layout: full height + centered content -->
    <main class="min-vh-100 d-flex flex-column">

        <div class="container flex-grow-1 d-flex align-items-center justify-content-center py-5">

            <div class="w-100" style="max-width: 460px;">

                <h1 class="h3 fw-bold mb-3">Connexion</h1>

                <?php if ($flash): ?>
                    <?php
                    $type = $flash['type'] ?? 'success';
                    $bsClass = $type === 'error' ? 'alert-danger' : 'alert-success';
                    ?>
                    <div class="alert <?= e($bsClass) ?> d-flex align-items-center" role="alert">
                        <div><?= e($flash['message'] ?? '') ?></div>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form method="POST" action="/login" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="ex: nom@email.com"
                                    required>
                                <div class="invalid-feedback">Merci de renseigner un email valide.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Votre mot de passe"
                                    required>
                                <div class="invalid-feedback">Merci de renseigner votre mot de passe.</div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 rounded-pill py-2">
                                Se connecter
                            </button>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="/" class="btn btn-outline-secondary rounded-pill px-4">
                                ← Retour accueil
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <footer class="py-4 text-center text-secondary small">
            Touche pas au klaxon — © <?= date('Y') ?>
        </footer>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Small Bootstrap validation (optional but nice) -->
    <script>
        (function() {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

</body>

</html>