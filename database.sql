CREATE DATABASE IF NOT EXISTS KARI;

#Table users
CREATE TABLE IF NOT EXISTS users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(20) NOT NULL,
    role VARCHAR(20) NOT NULL,
    email VARCHAR(20) UNIQUE NOT NULL,
    statut BOOLEAN,
    password VARCHAR(250) NOT NULL
)

#Table logements
CREATE TABLE IF NOT EXISTS logements(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    CONSTRAINT fk_logements_users Foreign Key (user_id) REFERENCES users(id),
    title VARCHAR(20) NOT NULL,
    hote VARCHAR(20) not NULL,
    prix DECIMAL(10.2) check(prix > 0),
    description VARCHAR(50) NOT NULL,
    statut BOOLEAN,
    date_start DATE DEFAULT CURRENT_DATE,
    date_end DATE DEFAULT CURRENT_DATE,
    ville VARCHAR(20) NOT NULL,
    created_at DATE DEFAULT CURRENT_DATE
)


#Table reservation
CREATE TABLE IF NOT EXISTS reservation(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    CONSTRAINT fk_reservation_users Foreign Key (user_id) REFERENCES users(id),
    logement_id INT,
    CONSTRAINT fk_reservation_logements Foreign Key (logement_id) REFERENCES logements(id),
    date_start DATE DEFAULT CURRENT_DATE,
    date_end DATE DEFAULT CURRENT_DATE,
    created_at DATE DEFAULT CURRENT_DATE
)

#Table review
CREATE TABLE IF NOT EXISTS review(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    CONSTRAINT fk_review_users Foreign Key (user_id) REFERENCES users(id),
    logement_id INT,
    CONSTRAINT fk_review_logements Foreign Key (logement_id) REFERENCES logements(id),
    created_at DATE DEFAULT CURRENT_DATE
)

#Table favoris
CREATE TABLE IF NOT EXISTS favoris(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    CONSTRAINT fk_favoris_users Foreign Key (user_id) REFERENCES users(id),
    logement_id INT,
    CONSTRAINT fk_favoris_logements Foreign Key (logement_id) REFERENCES logements(id),
    created_at DATE DEFAULT CURRENT_DATE
)