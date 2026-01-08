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

        $logement_id = $reservation->getLogementId();
        $sql2 = "UPDATE logements SET statut = 1 WHERE id = $logement_id";
        $stmt2 = $this->pdo->query($sql2);
    }

    public function find(int $id){

    }
}