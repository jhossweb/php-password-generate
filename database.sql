CREATE DATABASE passgen;
USE passgen;

create table users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255),
    token VARCHAR(255)
);

CREATE TABLE passwords (
    id INT PRIMARY KEY AUTO_INCREMENT,
    platform VARCHAR (100) NOT NULL,
    url_platform VARCHAR(255),
    pass_gen VARCHAR(255),
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Relaciones INNER JOIN
SELECT p.id, p.platform, p.url_platform, p.pass_gen, u.email
    FROM passwords AS p
    INNER JOIN users AS u
    ON u.id = p.user_id
    WHERE p.user_id = ?