<?php

require_once __DIR__ . "/../entities/Admin.php";
require_once __DIR__ . "/../repositories/AdminRepository.php";


class AdminService {
    private AdminRepository $repo;
    
    public function __construct(AdminRepository $repo){
        $this->repo = $repo; 
    }

    //statistique
    public function serviceStatistique(string $button) : int|float{
        if ($button === "getAllUsers") {
            $result = $this->repo->getAllUsers();
        }

        elseif ($button === "getAllLogements") {
            $result = $this->repo->getAllLogements();
        }

        elseif ($button === "getAllReservations") {
            $result = $this->repo->getAllReservations();
        }

        elseif ($button === "getSomeRevenus") {
            $result = $this->repo->getSomeRevenus();
        }
        
        return $result;
    }

    //get les 10 logements kes plus rentable
    public function serviceLogementRentable() : array{
        $result = $this->repo->getLogementRentable();
        return $result;
    }

    //activer ou desactiver un user ou un logement ou annuler une reservation
    public function serviceStatutAnnulation(string $button , string $table , bool $value , int $id){
       if ($button === "user_logement_statut") {
        $this->repo->statutUserLogement($table , $value , $id);
       }
       elseif ($button === "annuleReservation") {
        $this->repo->annuleReservation($id);
       }
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