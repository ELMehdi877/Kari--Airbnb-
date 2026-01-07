<?php 
require_once __DIR__ . "/../core/RepositoryInterface.php";
class LogementRepository {
    private PDO $pdo;

    //construct

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    //register dans database 
    public function save($logement){
        $stmt = $this->pdo->prepare("INSERT INTO logements(user_id,title,prix,description,statut,date_start,date_end,ville,image_path) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $logement->getUserId(),
            $logement->getTitle(),
            $logement->getPrix(),
            $logement->getDescription(),
            $logement->getStatut(),
            $logement->getDateStart(),
            $logement->getDateEnd(),
            $logement->getVille(),
            $logement->getImage_path()
        ]);
    }

    public function find($title){
        $stmt = $this->pdo->prepare("SELECT * FROM logements WHERE title = ?");
        $stmt->execute([$title]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function afficheLogement(){
        $sql = "SELECT l.*,u.fullname 
        FROM logements l
        LEFT JOIN users u
        ON l.user_id = u.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function afficheLogementByUser($user_id){
        $sql = "SELECT l.*
        FROM logements l
        LEFT JOIN users u
        ON l.user_id = u.id WHERE l.user_id = $user_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}