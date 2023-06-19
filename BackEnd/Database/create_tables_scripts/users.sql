DROP TABLE IF EXISTS USERS;

CREATE TABLE USERS (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    phone VARCHAR(10),
    adresa VARCHAR(255),
    descriere VARCHAR(255),
    hobby VARCHAR(255),
    interes_plant VARCHAR(255)
);