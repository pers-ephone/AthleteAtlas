CREATE DATABASE athleteatlas;

USE athleteatlas;

CREATE TABLE IF NOT EXISTS user(
    id_user INT AUTO_INCREMENT,
    pseudo VARCHAR(200),
    password VARCHAR(200),
    email VARCHAR(100),
    mail_valide TINYINT (1) DEFAULT 0,
    name VARCHAR(100),
    birthdate DATE,
    is_admin TINYINT (1) NOT NULL DEFAULT 0,
    token VARCHAR(200),
    reset_token VARCHAR(60),
    PRIMARY KEY(id_user),
    UNIQUE KEY email (email),
    UNIQUE KEY pseudo (pseudo)
);

CREATE TABLE IF NOT EXISTS performance(
    id_performance INT AUTO_INCREMENT,
    distance DECIMAL(15,2),
    duree TIME,
    average_speed DECIMAL(5,2),
    sport VARCHAR(50),
    id_user INT NOT NULL,
    PRIMARY KEY(id_performance),
    FOREIGN KEY(id_user) REFERENCES user(id_user)
);