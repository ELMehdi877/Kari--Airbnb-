<?php 
require_once __DIR__ . "/../core/RepositoryInterface.php";

class UserRepository implements RepositoryInterface {
    private PDO $pdo;

    // __construct

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // register dans baes de donner
    public function save($user){
        $sql = "INSERT INTO users(fullname,role,email,password,statut,photo) VALUES (?,?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $user->getfullname(),
            $user->getRole(),
            $user->getemail(),
            $user->getpassword(),
            $user->getstatut(),
            $user->getphoto()
        ]);
    }

    // verification par email
    public function find($email){
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // get tous les users
    public function getAllUsers($id) : array{
        $sql = "SELECT * FROM users WHERE id = $id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // update info
    public function updateInfoUser(string|null $photo,string $fullname , string $email , string $password , int $id){
        $sql = "UPDATE users SET photo = ? , fullname = ? , email = ? , password = ? WHERE id = $id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $photo,
            $fullname,
            $email,
            $password
        ]);
    }


    // verification si l'email exist a un autre utilisateur a part lui meme
    public function findUser($email  , $user_id){
        $sql = "SELECT * FROM users WHERE email = ? AND id != $user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}