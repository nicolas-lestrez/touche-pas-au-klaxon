CREATE TABLE UTILISATEUR (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    prenom VARCHAR(150) NOT NULL,
    telephone VARCHAR(25) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(10) NOT NULL
);

CREATE TABLE AGENCE (
    id_agence INT AUTO_INCREMENT PRIMARY KEY,
    ville VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE TRAJET (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    gdh_depart DATETIME NOT NULL,
    gdh_arrivee DATETIME NOT NULL,
    nb_places_total INT NOT NULL,
    nb_places_disponibles INT NOT NULL,

    id_auteur INT NOT NULL,
    id_contact INT NOT NULL,
    id_agence_depart INT NOT NULL,
    id_agence_arrivee INT NOT NULL,

    CONSTRAINT fk_trajet_auteur
        FOREIGN KEY (id_auteur)
        REFERENCES UTILISATEUR(id_utilisateur),

    CONSTRAINT fk_trajet_contact
        FOREIGN KEY (id_contact)
        REFERENCES UTILISATEUR(id_utilisateur),

    CONSTRAINT fk_trajet_agence_depart
        FOREIGN KEY (id_agence_depart)
        REFERENCES AGENCE(id_agence),

    CONSTRAINT fk_trajet_agence_arrivee
        FOREIGN KEY (id_agence_arrivee)
        REFERENCES AGENCE(id_agence),

    CONSTRAINT chk_places
        CHECK (nb_places_disponibles <= nb_places_total),

    CONSTRAINT chk_dates
        CHECK (gdh_arrivee > gdh_depart)
);
