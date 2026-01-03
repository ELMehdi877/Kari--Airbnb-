<?php 
require_once __DIR__ . "/../core/RepositoryInterface";

class UserRepository implements RepositoryInterface {
    private PDO $pdo;

    // __construct

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // register dans baes de donner
    public function save($user){
        $stmt = $this->pdo->prepare("INSERT INTO users(fullname,role,email,password,statut) VALUES (?,?,?,?,?)");
        $stmt->execute([
            $user->fullname,
            $user->getRole(),
            $user->email,
            $user->password,
            $user->statut
        ]);
    }

    // verification par email
    public function finByEmail($email){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}