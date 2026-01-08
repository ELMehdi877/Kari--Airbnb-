<?php

class ReservationRepository{
    public PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }  

    public function save($reservation){
        $sql = "INSERT INTO reservation(user_is,logement_id,date_start,date_end,created_at) VALUES (?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $reservation->getUserId(),
            $reservation->getLogementId(),
            $reservation->getDateStart(),
            $reservation->getDateEnd(),
            $reservation->getCreatedAt()
        ]);
    }

    public function find(int $id){
        
    }
}