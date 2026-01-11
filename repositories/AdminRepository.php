<?php
class AdminRepository{
    public PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }  

    //get total de users
    public function getAllUsers() : int {
        $sql = "SELECT COUNT(id) as total_users FROM users WHERE role != 'admin' ";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["total_users"]; 
    }

    //get total de logements
    public function getAllLogements() : int{
        $sql = "SELECT COUNT(id) as total_logements FROM logements ";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["total_logements"];   
    }

    //get total de reservations
    public function getAllReservations() : int{
        $sql = "SELECT COUNT(id) as total_reservations FROM reservation ";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["total_reservations"];   
    }

    //calcul le total des revenus 
    public function getSomeRevenus() : float{
        $sql = "SELECT SUM(l.prix) as total_revenus
        FROM logements l
        INNER JOIN reservation r ON r.logement_id = l.id";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC) ;
        return (float) ($result["total_revenus"] ?: 0);   
    }

    //get les 10 logements les plus rentable
    public function getLogementRentable(){
        $sql = "SELECT COUNT(r.logement_id) as total_revenus ,r.id ,r.user_id, l.*,u.fullname
        FROM reservation r
        INNER JOIN logements l ON r.logement_id = l.id
        INNER JOIN users u ON l.user_id = u.id
        GROUP BY r.logement_id ORDER BY total_revenus DESC LIMIT 10";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];   
    }

    //get tous les logements
    public function afficheLogement(){
        $sql = "SELECT l.*,u.fullname 
        FROM logements l
        LEFT JOIN users u
        ON l.user_id = u.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //get tous les users
    public function afficheUers() :array {
        $sql = "SELECT * FROM users WHERE role != 'admin' ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    //activer ou desactiver un user ou un logement
    public function statutUserLogement(string $table , int $value , int $id){
        $sql = "UPDATE $table SET statut = $value WHERE id = $id";
        $stmt = $this->pdo->query($sql);
    }


    //get tous les reservation

    public function getAllReservation(){
        $sql = "SELECT r.id,r.date_start,r.date_end,l.image_path,l.ville,l.prix,l.title,u.fullname
        FROM reservation r
        INNER JOIN logements l ON l.id = r.logement_id
        INNER JOIN users u ON u.id = r.user_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //annuler une reservation
    public function annuleReservation(int $id){
        $sql = "DELETE FROM reservation WHERE id = $id";
        $stmt = $this->pdo->query($sql);
    }

}