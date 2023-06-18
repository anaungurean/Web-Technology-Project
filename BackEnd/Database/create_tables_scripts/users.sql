DROP TABLE IF EXISTS USERS;

CREATE TABLE USERS (
    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    EMAIL VARCHAR(255) NOT NULL UNIQUE,
    USERNAME VARCHAR(255) NOT NULL UNIQUE,
    PASSWORD_HASH VARCHAR(255) NOT NULL
);