CREATE TABLE `user` (
    id INTEGER NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) CHARACTER SET utf8 NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    registration_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    birthdate DATE,
    gender ENUM ('masculin', 'feminin', 'non precisé') CHARACTER SET utf8 DEFAULT 'non precisé',
    PRIMARY KEY (id),
    UNIQUE u_email(email) USING BTREE
);

CREATE TABLE auth_user (
    id_user INTEGER NOT NULL,
    last_connection DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    token VARCHAR(128) NOT NULL,
    token_valid_until DATE,
    FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE
);

INSERT INTO `user`(email, firstname, lastname, password) VALUES ('user@test.com', 'user', 'test', 'mot de passe invalide');