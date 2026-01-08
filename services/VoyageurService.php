<?php

require_once __DIR__ . "/../entities/Voyageur.php";
require_once __DIR__ . "/../repositories/UserRepository.php";


class VoyageurService {
    private UserRepository $repo;

    public function __construct(UserRepository $repo){
        $this->repo = $repo; 
    }

    public function registerVoyageur(string $fullname , string $email , string $password){
        if ($this->repo->find($email)) {
            return "ce email existe déjat";
        }

        else {
            $voyageur = new Voyageur($fullname,$email,$password);
            $this->repo->save($voyageur);
            return "done";
        }

    }
}
