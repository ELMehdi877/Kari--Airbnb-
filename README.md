# 🏠 Rental Platform – Plateforme de Location Courte Durée

Rental Platform est une application web permettant à des **hôtes** de publier des logements et à des **voyageurs** de réserver facilement des hébergements disponibles.  
Le projet est développé en **PHP Orienté Objet & MySQL**, en respectant les bonnes pratiques de **clean code**, de sécurité et de maintenabilité.

L’objectif est de proposer une application **robuste**, **évolutive** et prête à devenir une vraie plateforme commerciale.

---

## 🚀 Fonctionnalités principales

### 🟢 Authentification & Utilisateurs

- Création de compte et connexion sécurisée
- Gestion des rôles : **voyageur, hôte, admin**
- Consultation et modification du profil utilisateur
- Vérification automatique des permissions selon le rôle

---

### 🟢 Gestion des logements (Rentals)

- Ajout de logements par les hôtes
- Modification et suppression des logements
- Consultation de la liste des logements disponibles
- Consultation du détail d’un logement :
  - Prix
  - Ville
  - Dates disponibles
  - Informations de l’hôte

---

### 🟢 Réservations

- Réservation d’un logement disponible par un voyageur
- Annulation d’une réservation :
  - Un utilisateur peut annuler **ses propres réservations**
  - Un admin peut annuler **toutes les réservations**
- Téléchargement d’un **reçu PDF** de réservation

---

### 🟢 Système de favoris

- Ajout d’un logement aux favoris
- Consultation de la liste des favoris
- Suppression d’un logement des favoris

---

### 🟢 Notifications par email

- Envoi d’un email lors :
  - D’une nouvelle réservation
  - D’une annulation de réservation
- Centralisation de l’envoi des emails (PHPMailer)

---


### 🟢 Administration & Statistiques

- Tableau de bord administrateur
- Consultation :
  - Nombre total d’utilisateurs
  - Nombre de logements
  - Nombre de réservations
  - Revenus générés
  - Top 10 des logements les plus rentables
- Activation / désactivation :
  - Des utilisateurs
  - Des logements
- Annulation d’une réservation en cas de problème ou réclamation

---

## 🟢 Base de données SQL

- Conception complète de la base de données
- Tables principales :
  - `users`
  - `logements`
  - `reservation`
  - `favoris`
  - `reviews`
- Utilisation de :
  - Clés primaires et étrangères
  - Contraintes (`NOT NULL`, `UNIQUE`, `CHECK`)
  - `ON DELETE CASCADE`
- Fourniture d’un fichier unique : `database.sql`

---

## 🛠️ Technologies utilisées

- **PHP 8+ (Orienté Objet)**
- **MySQL**
- **HTML5**
- **CSS3 / TailwindCSS**
- **JavaScript (ES6+)**
- **FPDF** (génération de PDF)
- **PHPMailer** (envoi d’emails)

