<?php

require_once __DIR__ . "/../entities/Hote.php";
require_once __DIR__ . "/../repositories/UserRepository.php";


class HoteService {
    private $repo;

    public function __construct($repo){
        $this->repo = $repo; 
    }

    public function registerHote(string $fullname , string $email , string $password){
        if ($this->repo->findByEmail($email)) {
            return "ce email existe déjat";
        }
        
        else {
            $voyageur = new Hote($fullname,$email,$password);
            $this->repo->save($voyageur);
            return "done";
        }

    }
}