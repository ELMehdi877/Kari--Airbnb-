<?php

require_once __DIR__ . "/../repositories/UserRepository.php";


class UserService {
    private UserRepository $repo;
    
    public function __construct(UserRepository $repo){
        $this->repo = $repo; 
    }

    // update profil service
    public function updateInfoUserService(string|null $photo ,string $fullname ,string $email ,string $password ,int $user_id) : string{
        if ($this->repo->findUser($email , $user_id)) {
            return "ce email existe déjat";
        }

        else {
            $this->repo->updateInfoUser($photo , $fullname , $email , $password , $user_id);
            return "l'operation est valider";
        }
    }
}