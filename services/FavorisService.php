<?php
require_once __DIR__ . "/../entities/Favoris.php";
class FavorisService{
    private FavorisRepository $repo;

    public function __construct(FavorisRepository $repo){
        $this->repo = $repo;
    }

    public function seveFavorisService($user_id , $logement_id){
        $favoris = new Favoris($user_id , $logement_id);
        $this->repo->save($favoris);
    }

    public function deleteFavorisService($favoris_id){
        $this->repo->deleteFavoris($favoris_id); 

    }
}