<?php

require_once __DIR__ . "/../entities/Logement.php";
require_once __DIR__ . "/../repositories/UserRepository.php";


class LogementService {
    private $repo;

    public function __construct($repo){
        $this->repo = $repo; 
    }

    public function registerLogement(int $user_id,string $title,float $prix,string $description,string $date_start,string $date_end,string $ville,string $image_path){
        if ($this->repo->find($title)) {
            return "ce logement avec ce titre existe déjat";
        }

        else {
            $logement = new Logement($user_id , $title , $prix , $description , $date_start , $date_end , $ville , $image_path);
            $this->repo->save($logement);
            return "vous avez ajouter un nouveau Logement";
        }

    }
}