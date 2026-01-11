DROP DATABASE KARI;
CREATE DATABASE IF NOT EXISTS KARI;
use KARI;
#Table users
CREATE TABLE IF NOT EXISTS users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(20) NOT NULL,
    role VARCHAR(20) NOT NULL,
    email VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(250) NOT NULL,
    statut BOOLEAN,
    created_at DATE DEFAULT CURRENT_DATE
)


#Table logements
CREATE TABLE IF NOT EXISTS logements(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    CONSTRAINT fk_logements_users Foreign Key (user_id) REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(20) NOT NULL,
    prix DECIMAL(10,2) check(prix > 0),
    description VARCHAR(250) NOT NULL,
    statut BOOLEAN,
    ville VARCHAR(20) NOT NULL,
    image_path VARCHAR(250) UNIQUE NOT NULL,
    created_at DATE DEFAULT CURRENT_DATE
)

-- alter table logements ADD COLUMN date_end DATE DEFAULT CURRENT_DATE;
#Table reservation
CREATE TABLE IF NOT EXISTS reservation(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    CONSTRAINT fk_reservation_users Foreign Key (user_id) REFERENCES users(id) ON DELETE CASCADE,
    logement_id INT,
    CONSTRAINT fk_reservation_logements Foreign Key (logement_id) REFERENCES logements(id) ON DELETE CASCADE,
    date_start DATE DEFAULT CURRENT_DATE,
    date_end DATE DEFAULT CURRENT_DATE,
    created_at DATE DEFAULT CURRENT_DATE
)


#Table review
CREATE TABLE IF NOT EXISTS review(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    CONSTRAINT fk_review_users Foreign Key (user_id) REFERENCES users(id) ON DELETE CASCADE,
    logement_id INT,
    CONSTRAINT fk_review_logements Foreign Key (logement_id) REFERENCES logements(id) ON DELETE CASCADE,
    created_at DATE DEFAULT CURRENT_DATE
)

#Table favoris
CREATE TABLE IF NOT EXISTS favoris(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    CONSTRAINT fk_favoris_users Foreign Key (user_id) REFERENCES users(id) ON DELETE CASCADE,
    logement_id INT,
    CONSTRAINT fk_favoris_logements Foreign Key (logement_id) REFERENCES logements(id) ON DELETE CASCADE,
    created_at DATE DEFAULT CURRENT_DATE
)

SELECT COUNT(r.id) as total_revenus,r.logement_id ,r.user_id, l.*,u.fullname
        FROM reservation r
        INNER JOIN logements l ON r.logement_id = l.id
        INNER JOIN users u ON l.user_id = u.id
        GROUP BY r.logement_id ORDER BY total_revenus DESC LIMIT 10;

INSERT INTO users(fullname,role,email,password,statut) VALUES ("lahrach","admin","lahrach@gmail.com","$2y$10$5Iv9gQsoO70IYo.cwv/GA.5smvLgtsON0mvs/JCgxK2Sm7yGLjCe.",1);
