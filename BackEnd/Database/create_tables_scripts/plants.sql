DROP TABLE IF EXISTS PLANTS;

CREATE TABLE PLANTS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    common_name VARCHAR(255),
    scientific_name VARCHAR(255),
    family VARCHAR(255),
    genus VARCHAR(255),
    species VARCHAR(255),
    place VARCHAR(255),
    date_of_collection DATE,
    color VARCHAR(255),
    collection_name VARCHAR(255),
    hashtags VARCHAR(255),
    filename VARCHAR(255),
    FOREIGN KEY (id_user) REFERENCES users(id)
);
