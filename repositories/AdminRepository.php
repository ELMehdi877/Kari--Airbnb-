<?php
class AdminRepository{
    public PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }  

    //get tous les users
    public function getAllUsers(){
        $sql = "SELECT COUNT(id) as total_users FROM users WHERE role != 'admin' ";
        $stmt = $this->pdo->query($sql);
        return total_users;   
    }

    //get tous les logements
    public function getAllLogements(){
        $sql = "SELECT COUNT(id) as total_logements FROM logements ";
        $stmt = $this->pdo->query($sql);
        return total_logements;   
    }

    //get tous les reservations
    public function getAllReservations(){
        $sql = "SELECT COUNT(id) as total_reservations FROM logements ";
        $stmt = $this->pdo->query($sql);
        return total_reservations;   
    }

    //calcul le total des revenus 
    public function getSomeRevenus(){
        $sql = "SELECT SUM(l.prix) as total_revenus
        FROM logements l
        INNER JOIN reservation r ON r.logement_id = l.id";
        $stmt = $this->pdo->query($sql);
        return total_revenus;   
    }

    //get les 10 logements kes plus rentable
    public function getLogementRentable(){
        $sql = "SELECT COUNT(r.id) as total_revenus,r.logement_id , l.*
        FROM reservation r
        INNER JOIN logements l ON r.logement_id = l.id
        GROUP BY r.logement_id ORDER BY total_revenus DESC LIMIT 10";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);;   
    }

    //activer un user ou un logement
    public function activeUserLogement(string $table , int $id){
        $sql = "UPDATE $table SET statut = 1 WHERE id = $id";
        $stmt = $this->pdo->query($sql);
    }

    //desactiver un user ou un logement
    public function desactiveUserLogement(string $table , int $id){
        $sql = "UPDATE $table SET statut = 0 WHERE id = $id";
        $stmt = $this->pdo->query($sql);
    }

    //annuler une reservation
    public function annuleReservation(int $id){
        $sql = "DELETE FROM reservation WHERE id = $id";
        $stmt = $this->pdo->query($sql);
    }

}