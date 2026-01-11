DROP DATABASE KARI;
CREATE DATABASE IF NOT EXISTS KARI;
use KARI;
#Table users
CREATE TABLE IF NOT EXISTS users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(20) NOT NULL,
    role VARCHAR(20) NOT NULL,
    email VARCHAR(250) UNIQUE NOT NULL,
    password VARCHAR(250) NOT NULL,
    statut BOOLEAN,
    created_at DATE DEFAULT CURRENT_DATE,
    photo VARCHAR(250)
)

alter table users modify column email VARCHAR(250) UNIQUE NOT NULL;

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
        GROUP BY r.logement_id ORDER BY total_revenus ASC LIMIT 10;

INSERT INTO users(fullname,role,email,password,statut) VALUES ("lahrach","admin","lahrach@gmail.com","$2y$10$5Iv9gQsoO70IYo.cwv/GA.5smvLgtsON0mvs/JCgxK2Sm7yGLjCe.",4);

INSERT INTO logements (user_id, title, prix, description, statut, ville, image_path)
VALUES
(4, 'Appartement Centre', 500.00, 'Bel appartement avec balcon', TRUE, 'Casablanca', 'images/logement1.jpg'),
(4, 'Studio Moderne', 350.00, 'Studio confortable pour 2 personnes', TRUE, 'Rabat', 'images/logement2.jpg'),
(4, 'Villa Luxueuse', 1200.00, 'Villa avec piscine et jardin', TRUE, 'Marrakech', 'images/logement3.jpg'),
(4, 'Appartement Vue Mer', 700.00, 'Appartement avec vue sur la mer', TRUE, 'Agadir', 'images/logement4.jpg'),
(4, 'Petit Studio', 300.00, 'Studio simple et fonctionnel', TRUE, 'Fès', 'images/logement5.jpg'),
(4, 'Maison Familiale', 900.00, 'Maison spacieuse pour famille', TRUE, 'Tanger', 'images/logement6.jpg'),
(4, 'Appartement Moderne', 600.00, 'Appartement rénové avec cuisine équipée', TRUE, 'Casablanca', 'images/logement7.jpg'),
(4, 'Studio Central', 400.00, 'Studio au centre-ville', TRUE, 'Rabat', 'images/logement8.jpg'),
(4, 'Villa Panorama', 1500.00, 'Villa avec vue panoramique', TRUE, 'Marrakech', 'images/logement9.jpg'),
(4, 'Appartement Jardin', 550.00, 'Appartement avec petit jardin', TRUE, 'Agadir', 'images/logement10.jpg'),
(4, 'Studio Confort', 380.00, 'Studio confortable et lumineux', TRUE, 'Fès', 'images/logement11.jpg'),
(4, 'Maison Moderne', 1000.00, 'Maison moderne avec terrasse', TRUE, 'Tanger', 'images/logement12.jpg'),
(4, 'Appartement Chic', 650.00, 'Appartement chic au centre-ville', TRUE, 'Casablanca', 'images/logement13.jpg'),
(4, 'Studio Économique', 320.00, 'Studio pas cher et pratique', TRUE, 'Rabat', 'images/logement14.jpg'),
(4, 'Villa de Luxe', 1800.00, 'Villa de luxe avec piscine', TRUE, 'Marrakech', 'images/logement15.jpg'),
(4, 'Appartement Cosy', 500.00, 'Appartement cosy pour couple', TRUE, 'Agadir', 'images/logement16.jpg'),
(4, 'Studio Moderne', 350.00, 'Studio moderne et bien situé', TRUE, 'Fès', 'images/logement17.jpg'),
(4, 'Maison Spacieuse', 1200.00, 'Maison spacieuse avec jardin', TRUE, 'Tanger', 'images/logement18.jpg'),
(4, 'Appartement Vue Ville', 600.00, 'Appartement avec belle vue', TRUE, 'Casablanca', 'images/logement19.jpg'),
(4, 'Studio Petit Prix', 300.00, 'Studio pratique à petit prix', TRUE, 'Rabat', 'images/logement20.jpg');


INSERT INTO reservation (user_id, logement_id, date_start, date_end)
VALUES
(4, 20, '2026-01-05', '2026-01-10'),
(4, 20, '2026-01-15', '2026-01-18'),
(4, 20, '2026-02-01', '2026-02-05'),

(4, 21, '2026-01-07', '2026-01-09'),
(4, 21, '2026-01-20', '2026-01-25'),

(4, 22, '2026-02-10', '2026-02-15'),
(4, 22, '2026-03-01', '2026-03-07'),

(4, 23, '2026-01-12', '2026-01-14'),
(4, 23, '2026-01-18', '2026-01-22'),

(4, 24, '2026-02-05', '2026-02-08'),

(4, 25, '2026-01-10', '2026-01-15'),
(4, 25, '2026-02-20', '2026-02-25'),

(4, 26, '2026-01-03', '2026-01-06'),
(4, 26, '2026-01-25', '2026-01-30'),

(4, 27, '2026-02-10', '2026-02-12'),

(4, 28, '2026-03-05', '2026-03-10'),
(4, 28, '2026-03-15', '2026-03-20'),

(4, 17, '2026-01-08', '2026-01-12'),

(4, 20, '2026-02-18', '2026-02-22'),

(4, 10, '2026-03-01', '2026-03-05');


