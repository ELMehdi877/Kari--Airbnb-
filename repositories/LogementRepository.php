<?php 
require_once __DIR__ . "/../core/RepositoryInterface.php";
class LogementRepository {
    private PDO $pdo;

    //construct

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    //INSERT
    public function save($logement){
        $stmt = $this->pdo->prepare("INSERT INTO logements(user_id,title,prix,description,statut,ville,image_path) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([
            $logement->getUserId(),
            $logement->getTitle(), 
            $logement->getPrix(),
            $logement->getDescription(),
            $logement->getStatut(),
            $logement->getVille(),
            $logement->getImage_path()
        ]);
    }

    //CHECK BY TITLE
    public function find(string $title){
        $stmt = $this->pdo->prepare("SELECT * FROM logements WHERE title = ?");
        $stmt->execute([$title]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //SELECT ALL
    public function afficheLogement(){
        $sql = "SELECT l.*,u.fullname 
        FROM logements l
        LEFT JOIN users u
        ON l.user_id = u.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //SELECT BY USER
    public function afficheLogementByUser(int $user_id){
        $sql = "SELECT l.*
        FROM logements l
        LEFT JOIN users u
        ON l.user_id = u.id WHERE l.user_id = $user_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //UPDATE
    public function updateLogement(int $id , Logement $logement){
        $sql = "UPDATE logements SET title = ? , prix = ? , description = ? , ville = ? WHERE id= $id AND user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $logement->getTitle(),
            $logement->getPrix(),
            $logement->getDescription(),
            $logement->getVille(),
            $logement->getUserId()
        ]);
    }
    
    //DELETE
    
        public function deleteLogement(int $id){
            $sql = "DELETE FROM logements WHERE id = $id";
            $stmt = $this->pdo->query($sql);
        }   
}