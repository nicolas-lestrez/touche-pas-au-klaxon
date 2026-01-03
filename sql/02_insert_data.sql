-- =========================================================
-- 02_insert_data.sql
-- Jeu d'essai : agences + utilisateurs + admin + trajets
-- Compatible MySQL / MariaDB
-- =========================================================

SET NAMES utf8mb4;

START TRANSACTION;

-- ---------------------------------------------------------
-- AGENCES (agences.txt)
-- ---------------------------------------------------------
INSERT INTO AGENCE (ville) VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Toulouse'),
('Nice'),
('Nantes'),
('Strasbourg'),
('Montpellier'),
('Bordeaux'),
('Lille'),
('Rennes'),
('Reims');

-- ---------------------------------------------------------
-- UTILISATEURS (users.txt)
-- Mot de passe commun pour le jeu d'essai : klaxon2024!
-- Hash BCRYPT (généré avec PHP password_hash)
-- ---------------------------------------------------------
SET @PWD_HASH = '$2y$10$vv/btoW/7nYWBiwW6SN1UOKJq.TYmHzbPFWPa9l7Re4jnK7OqJYfS';

INSERT INTO UTILISATEUR (nom, prenom, telephone, email, mot_de_passe, role) VALUES
('Martin','Alexandre','0612345678','alexandre.martin@email.fr', @PWD_HASH, 'USER'),
('Dubois','Sophie','0698765432','sophie.dubois@email.fr', @PWD_HASH, 'USER'),
('Bernard','Julien','0622446688','julien.bernard@email.fr', @PWD_HASH, 'USER'),
('Moreau','Camille','0611223344','camille.moreau@email.fr', @PWD_HASH, 'USER'),
('Lefèvre','Lucie','0777889900','lucie.lefevre@email.fr', @PWD_HASH, 'USER'),
('Leroy','Thomas','0655443322','thomas.leroy@email.fr', @PWD_HASH, 'USER'),
('Roux','Chloé','0633221199','chloe.roux@email.fr', @PWD_HASH, 'USER'),
('Petit','Maxime','0766778899','maxime.petit@email.fr', @PWD_HASH, 'USER'),
('Garnier','Laura','0688776655','laura.garnier@email.fr', @PWD_HASH, 'USER'),
('Dupuis','Antoine','0744556677','antoine.dupuis@email.fr', @PWD_HASH, 'USER'),
('Lefebvre','Emma','0699887766','emma.lefebvre@email.fr', @PWD_HASH, 'USER'),
('Fontaine','Louis','0655667788','louis.fontaine@email.fr', @PWD_HASH, 'USER'),
('Chevalier','Clara','0788990011','clara.chevalier@email.fr', @PWD_HASH, 'USER'),
('Robin','Nicolas','0644332211','nicolas.robin@email.fr', @PWD_HASH, 'USER'),
('Gauthier','Marine','0677889922','marine.gauthier@email.fr', @PWD_HASH, 'USER'),
('Fournier','Pierre','0722334455','pierre.fournier@email.fr', @PWD_HASH, 'USER'),
('Girard','Sarah','0688665544','sarah.girard@email.fr', @PWD_HASH, 'USER'),
('Lambert','Hugo','0611223366','hugo.lambert@email.fr', @PWD_HASH, 'USER'),
('Masson','Julie','0733445566','julie.masson@email.fr', @PWD_HASH, 'USER'),
('Henry','Arthur','0666554433','arthur.henry@email.fr', @PWD_HASH, 'USER');

-- ---------------------------------------------------------
-- 1 COMPTE ADMIN (pour le livrable)
-- ---------------------------------------------------------
INSERT INTO UTILISATEUR (nom, prenom, telephone, email, mot_de_passe, role) VALUES
('Admin','Super','0600000000','admin@klaxon.local', @PWD_HASH, 'ADMIN');

-- ---------------------------------------------------------
-- TRAJETS (quelques trajets futurs pour tester l’accueil)
-- On utilise des sous-requêtes pour ne pas dépendre des IDs
-- ---------------------------------------------------------
INSERT INTO TRAJET
(gdh_depart, gdh_arrivee, nb_places_total, nb_places_disponibles,
 id_auteur, id_contact, id_agence_depart, id_agence_arrivee)
VALUES
(
  DATE_ADD(NOW(), INTERVAL 2 DAY),
  DATE_ADD(NOW(), INTERVAL 2 DAY) + INTERVAL 3 HOUR,
  4, 3,
  (SELECT id_utilisateur FROM UTILISATEUR WHERE email='alexandre.martin@email.fr'),
  (SELECT id_utilisateur FROM UTILISATEUR WHERE email='alexandre.martin@email.fr'),
  (SELECT id_agence FROM AGENCE WHERE ville='Paris'),
  (SELECT id_agence FROM AGENCE WHERE ville='Lyon')
),
(
  DATE_ADD(NOW(), INTERVAL 4 DAY),
  DATE_ADD(NOW(), INTERVAL 4 DAY) + INTERVAL 5 HOUR,
  3, 1,
  (SELECT id_utilisateur FROM UTILISATEUR WHERE email='sophie.dubois@email.fr'),
  (SELECT id_utilisateur FROM UTILISATEUR WHERE email='sophie.dubois@email.fr'),
  (SELECT id_agence FROM AGENCE WHERE ville='Lille'),
  (SELECT id_agence FROM AGENCE WHERE ville='Reims')
),
(
  DATE_ADD(NOW(), INTERVAL 7 DAY),
  DATE_ADD(NOW(), INTERVAL 7 DAY) + INTERVAL 2 HOUR,
  5, 5,
  (SELECT id_utilisateur FROM UTILISATEUR WHERE email='admin@klaxon.local'),
  (SELECT id_utilisateur FROM UTILISATEUR WHERE email='admin@klaxon.local'),
  (SELECT id_agence FROM AGENCE WHERE ville='Bordeaux'),
  (SELECT id_agence FROM AGENCE WHERE ville='Nantes')
);

COMMIT;
