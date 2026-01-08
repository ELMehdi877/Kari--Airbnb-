<?php
require_once __DIR__ . "/../entities/Reservation.php";
class ReservationService{
    private ReservationRepository $repo;

    public function __construct(ReservationRepository $repo){
        $this->repo = $repo;
    }

    public function seveReservationService($title,$user_id , $logement_id , $date_start , $date_end){
        $reservation = new Reservation($user_id , $logement_id , $date_start , $date_end);
        $this->repo->save($reservation);
        return "vous avez reserver le logement : ".$title;
    }
}