<?php

require_once __DIR__ . "/../entities/Hote.php";
require_once __DIR__ . "/../repositories/UserRepository.php";


class HoteService {
    private UserRepository $repo;

    public function __construct(UserRepository $repo){
        $this->repo = $repo; 
    }

    public function registerHote(string $fullname , string $email , string $password ){
        if ($this->repo->find($email)) {
            return "ce email existe déjat";
        }
        
        else {
            $voyageur = new Hote($fullname,$email,$password ,null);
            $this->repo->save($voyageur);
            return "done";
        }

    }
}