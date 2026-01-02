<?php
class Reservation {
    protected $id;
    protected $user_id;
    protected $logement_id;
    protected $date_start;
    protected $date_end;
    protected $created_at;

    // __construct
    public function __construct(int $user_id , int $logement_id , string $date_start , string $date_end) {
        $this->user_id = $user_id;
        $this->logement_id = $logement_id;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->created_at = date("Y-m-d");
    }

    // Getters
    public function getUserId() { return $this->user_id; }
    public function getLogementId() { return $this->logement_id; }
    public function getDateStart() { return $this->date_start; }
    public function getDateEnd() { return $this->date_end; }
    public function getCreatedAt() { return $this->created_at; }
}