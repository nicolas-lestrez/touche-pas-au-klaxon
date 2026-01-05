<?php

declare(strict_types=1);

require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController
{
    public function showLogin(): void
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Email et mot de passe requis.'];
            header('Location: /login');
            exit;
        }

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Identifiants incorrects.'];
            header('Location: /login');
            exit;
        }

        // On stocke l'utilisateur connecté en session (sans le hash du mdp si tu veux)
        $_SESSION['user'] = [
            'id_utilisateur' => (int) $user['id_utilisateur'],
            'id' => (int) $user['id_utilisateur'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Connexion réussie ✅'];
        header('Location: /');
        exit;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Déconnecté ✅'];
        header('Location: /');
        exit;
    }
}
