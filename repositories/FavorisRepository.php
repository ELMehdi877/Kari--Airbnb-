<?php

class FavorisRepository{
    public PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }  

    public function save($favoris){
        $user_id = $favoris->getUserId();
        $logement_id = $favoris->getLogementId();
        $sql = "INSERT INTO favoris(user_id,logement_id) VALUES ($user_id,$logement_id)";
        $stmt = $this->pdo->query($sql);
           
    }

    public function afficheFavoris($user_id){
        $sql = "SELECT f.id as favoris_id,l.*,u.fullname
        FROM favoris f
        INNER JOIN logements l ON l.id = f.logement_id
        INNER JOIN users u ON u.id = f.user_id
        WHERE f.user_id = $user_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteFavoris(int $favoris_id){
        $sql = "DELETE FROM favoris WHERE id = $favoris_id";
        $stmt = $this->pdo->query($sql);
    }
}