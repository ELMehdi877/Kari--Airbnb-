<?php

class ReservationRepository{
    public PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }  

    public function save($reservation){
        $sql1 = "INSERT INTO reservation(user_id,logement_id,date_start,date_end,created_at) VALUES (?,?,?,?,?)";
        $stmt1 = $this->pdo->prepare($sql1);
        $stmt1->execute([
            $reservation->getUserId(),
            $reservation->getLogementId(),
            $reservation->getDateStart(),
            $reservation->getDateEnd(),
            $reservation->getCreatedAt()
        ]);

        // $logement_id = $reservation->getLogementId();
        // $sql2 = "INSERT INTO logements(statut) VALUES  1 WHERE id = $logement_id";
        // $stmt2 = $this->pdo->query($sql2);
    }

    public function find(int $id){

    }

    public function afficheReservation($user_id){
        $sql = "SELECT r.id,r.date_start,r.date_end,l.image_path,l.ville,l.prix,l.title
        FROM reservation r
        INNER JOIN logements l ON l.id = r.logement_id
        WHERE r.user_id = $user_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteReservation($reservation_id){
        $sql = "DELETE FROM reservation WHERE id = $reservation_id";
        $stmt = $this->pdo->query($sql);
    }
}