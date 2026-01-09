<?php

require_once __DIR__ . "/../entities/Logement.php";
require_once __DIR__ . "/../repositories/LogementRepository.php";


class LogementService {
    private $repo;

    public function __construct($repo){
        $this->repo = $repo; 
    }

    //CHECK AND INSERT LOGEMENT
    public function registerLogement(int $user_id,string $title,float $prix,string $description,string $ville,string $image_path){
        if ($this->repo->find($title)) {
            return "ce logement avec ce titre existe déjat";
        }

        else {
            $logement = new Logement($user_id , $title , $prix , $description , $ville , $image_path);
            $this->repo->save($logement);
            return "vous avez ajouter un nouveau Logement";
        }

    }

    //UPDATE LOGEMENT
    public function updateLogementService(int $id,int $user_id,string $title,float $prix,string $description,string $ville){
        $logement = new Logement($user_id , $title , $prix , $description , $ville , "");
        $this->repo->updateLogement($id , $logement);
    }

    //DELETE LOGEMENT
    public function deletelogementService(int $id){
        
        $this->repo->deleteLogement($id);
    }

}