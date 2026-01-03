<?php

require_once __DIR__ . "/entities/Voyageur.php";
require_once __DIR__ . "/../repositories/UserRepository.php";

class UserService {
    private $repo;

    public function __construct($repo){
        $this->repo = $repo;
    }

    public function registerVoyageur(string $fullname , string $email , string $password){
        if ($this->repo->findByEmail($email)) {
            return "ce email existe déjat";
        }

        else {
            $voyageur = new Voyageur("mehdi","mehdi@gamil.com","123",true);
            $this->repo->save($voyageur);
            return "done";
        }

    }
}