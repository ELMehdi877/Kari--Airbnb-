<?php 
require_once __DIR__ . "/../core/RepositoryInterface.php";

class InfoUserRepository implements RepositoryInterface {
    private PDO $pdo;

    // __construct

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // register dans baes de donner
    public function save($user){
        $id = $user->getId();
        $sql = "UPDATE users SET photo = ? , fullname = ? , email = ? , password = ? WHERE id = $id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([

            $user->getPhoto(),
            $user->getfullname(),
            $user->getRole(),
            $user->getemail(),
            $user->getpassword()
        ]);
    }

    // verification par email
     // verification par email
    public function find($email , $id){
        $sql = "SELECT * FROM users WHERE email = ? AND id = $id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // update info
    public function updateInfoUser(string|null $photo,string $fullname , string $email , string $password , int $id){
        $sql = "UPDATE users SET photo = ? , fullname = ? , email = ? , password = ? WHERE id = $id";
        $stmt = $this->pdo->query($sql);
    }
}