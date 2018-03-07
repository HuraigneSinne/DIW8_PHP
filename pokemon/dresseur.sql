
CREATE TABLE dresseur (
    id            INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    prenom        VARCHAR(50)  NOT NULL,
    nom           VARCHAR(50)  NOT NULL,
    adresse       VARCHAR(255) NOT NULL,
    email         VARCHAR(255) NOT NULL UNIQUE,
    date_licence  DATE         NOT NULL,
    arene_prefere ENUM('Argenta', 'Azuria', 'Carmin-sur-Mer', 'Céladopole', 'Parmanie', 'Safrania', 'Cramois''Île', 'Jadielle')
);