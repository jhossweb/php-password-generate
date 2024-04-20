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
    pass_gen VARCHAR(255),
    user_id INT
);