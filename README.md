# 🚗 Touche pas au klaxon

## 1. Présentation du projet

### Nom de l’application

Touche pas au klaxon

### Contexte

Dans le cadre de ce devoir, il est demandé de concevoir et de développer une application web interne permettant aux employés d’une entreprise de proposer et consulter des trajets de covoiturage entre différents sites (agences) de l’entreprise.

L’application est destinée exclusivement aux postes de travail des employés.
Aucune version mobile ou tablette n’est demandée.

### Objectif de l’application

L’objectif de l’application **Touche pas au klaxon** est de faciliter le partage de trajets entre employés en mettant à disposition :

- une liste des trajets disponibles,
- un système de création, modification et suppression de trajets,
- une interface sécurisée selon le rôle de l’utilisateur,
- une interface d’administration pour la consultation des trajets, utilisateurs et agences.

---

## 2. Choix techniques

L’application repose sur les technologies suivantes :

- Langage : PHP
- Architecture : MVC (Modèle – Vue – Contrôleur)
- Base de données : MySQL / MariaDB
- Modélisation des données : Méthode Merise (MCD / MLD) réalisée avec Looping
- Interface utilisateur : HTML / CSS, Bootstrap 5 sur plusieurs pages
- Gestion des routes : Routeur PHP (Buki Router)
- Gestion de versions : Git et GitHub

---

## 3. Modélisation des données

### 3.1 Modèle Conceptuel de Données (MCD)

La modélisation des données a été réalisée selon la méthode Merise.

Le MCD met en évidence les entités suivantes :

- UTILISATEUR (employé)
- AGENCE (site / ville)
- TRAJET (trajet de covoiturage)

Les relations définissent :

- l’auteur d’un trajet,
- la personne de contact associée au trajet,
- l’agence de départ,
- l’agence d’arrivée.

Le MCD est fourni dans le livrable au format image (JPG / PNG / PDF).

---

### 3.2 Modèle Logique de Données (MLD – format textuel)

#### UTILISATEUR

- id_utilisateur (PK)
- nom
- prenom
- telephone
- email (unique)
- mot_de_passe
- role (USER / ADMIN)

#### AGENCE

- id_agence (PK)
- ville (unique)

#### TRAJET

- id_trajet (PK)
- gdh_depart
- gdh_arrivee
- nb_places_total
- nb_places_disponibles
- id_auteur (FK → UTILISATEUR)
- id_contact (FK → UTILISATEUR)
- id_agence_depart (FK → AGENCE)
- id_agence_arrivee (FK → AGENCE)

---

## 4. Scripts SQL

### 4.1 Création de la base de données

Le script de création des tables est disponible dans :
sql/01_create_tables.sql

### 4.2 Alimentation de la base

Le script d’initialisation des données est disponible dans :
sql/02_insert_data.sql

---

## 5. Architecture de l’application

L’application suit une architecture MVC.

### Modèles (app/Models)

- Database.php
- Trajet.php
- Utilisateur.php
- Agence.php
- User.php

### Contrôleurs (app/Controllers)

- TrajetController
- AdminController
- AdminTrajetController
- AdminUserController
- AdminAgenceController
- AuthController
- TrajetDetailsController

### Vues (app/Views)

- pages publiques (liste des trajets, détail),
- pages d’administration,
- pages d’authentification.

Les routes sont centralisées dans :
public/index.php

---

## 6. Gestion des utilisateurs et des rôles

### Utilisateur

- consultation des trajets,
- accès aux détails,
- affichage des coordonnées du contact.

### Administrateur

- gestion des trajets,
- consultation des utilisateurs et agences.

La sécurité repose sur :

- les sessions PHP,
- le contrôle d’accès serveur (`Auth::requireAdmin()`).

---

## 7. Comptes de test

Afin de permettre la correction et les tests complets de l’application, des comptes de démonstration sont fournis via le script d’alimentation de la base de données.

### Compte administrateur

- Email : admin@klaxon.local
- Mot de passe : klaxon2024!
- Rôle : ADMIN

Ce compte permet :

- l’accès à l’espace d’administration,
- la gestion des trajets,
- la consultation des utilisateurs,
- la consultation des agences.

### Comptes utilisateurs

Les comptes utilisateurs utilisent le même mot de passe que l’administrateur :

- Mot de passe : klaxon2024!
- Rôle : USER

Un utilisateur peut :

- consulter les trajets,
- accéder aux détails d’un trajet,
- voir les coordonnées du contact.

---

## 8. Installation et lancement de l’application

### Prérequis

- PHP 8.x
- MySQL ou MariaDB
- Serveur web local (Laragon, WAMP, XAMPP…)

### Installation

1. Cloner le dépôt :
   git clone https://github.com/nicolas-lestrez/touche-pas-au-klaxon.git

2. Créer une base de données MySQL.

3. Importer les scripts SQL :

- `01_create_tables.sql`
- `02_insert_data.sql`

4. Configurer la connexion dans :
   config/config.php

5. Lancer le serveur web.

6. Accéder à l’application dans le navigateur :
   http://localhost:4000

Si tu utilises le serveur PHP intégré :
php -S localhost:4000 -t public

---

## 9. Gestion des versions

Le projet est versionné avec Git et hébergé sur GitHub.
Les commits sont rédigés en anglais et organisés par fonctionnalités.

---

## 10. Conclusion

L’application **Touche pas au klaxon** répond aux exigences du cahier des charges :

- gestion des trajets,
- rôles utilisateurs,
- administration sécurisée,
- architecture MVC respectée.

Elle constitue une base fonctionnelle et évolutive.

---

© 2025 — Touche pas au klaxon
