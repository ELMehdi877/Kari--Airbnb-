<?php

require_once __DIR__ . "/../entities/Admin.php";
require_once __DIR__ . "/../repositories/UserRepository.php";


class AdminService {
    private $repo;

    public function __construct($repo){
        $this->repo = $repo; 
    }

    public function registerAdmin(string $fullname , string $email , string $password){
        if ($this->repo->find($email)) {
            return "ce email existe déjat";
        }

        else {
            $voyageur = new Admin($fullname,$email,$password);
            $this->repo->save($voyageur);
            return "done";
        }

    }
}