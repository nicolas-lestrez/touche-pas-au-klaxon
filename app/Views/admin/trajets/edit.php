<?php

declare(strict_types=1);

function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

// Pour remplir un input datetime-local : "YYYY-MM-DDTHH:MM"
function toDatetimeLocal(string $dt): string
{
    return date('Y-m-d\TH:i', strtotime($dt));
}

$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Modifier trajet #<?= e((string)$trajet['id_trajet']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <header class="w-100 border border-2 rounded-4 p-3 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <a href="/" class="fw-semibold fs-5 text-decoration-none text-dark">
                Touche pas au klaxon
            </a>

            <?php if ($user): ?>
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <a href="/admin/trajets/create" class="btn btn-dark rounded-pill px-4">
                        Créer un trajet
                    </a>
                    <div class="text-nowrap">
                        Bonjour <?= e(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?>
                    </div>
                    <a href="/logout" class="btn btn-dark rounded-pill px-4">
                        Déconnexion
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main class="container-fluid px-0">
        <h1 class="mb-3">Modifier le trajet #<?= e((string)$trajet['id_trajet']) ?></h1>

        <p class="mb-3">
            <a href="/admin" class="text-decoration-none">← Retour admin</a>
        </p>

        <form method="post" action="/admin/trajets/<?= e((string)$trajet['id_trajet']) ?>/update" class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Date & heure de départ</label>
                <input type="datetime-local" name="gdh_depart" class="form-control"
                    value="<?= e(toDatetimeLocal($trajet['gdh_depart'])) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Date & heure d’arrivée</label>
                <input type="datetime-local" name="gdh_arrivee" class="form-control"
                    value="<?= e(toDatetimeLocal($trajet['gdh_arrivee'])) ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Nombre de places total</label>
                <input type="number" name="nb_places_total" class="form-control" min="1"
                    value="<?= e((string)$trajet['nb_places_total']) ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Agence de départ (ID)</label>
                <input type="number" name="id_agence_depart" class="form-control" min="1"
                    value="<?= e((string)$trajet['id_agence_depart']) ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Agence d’arrivée (ID)</label>
                <input type="number" name="id_agence_arrivee" class="form-control" min="1"
                    value="<?= e((string)$trajet['id_agence_arrivee']) ?>" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                <a href="/admin" class="btn btn-outline-secondary">Annuler</a>
            </div>

        </form>
    </main>

    <footer style="margin-top: 40px; text-align: center; font-size: 0.9rem; color: #6c757d;">
        Touche pas au klaxon - Copyright <?= date('Y') ?>
    </footer>

</body>

</html>
