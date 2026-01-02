<?php
class Review {
    protected $id;
    protected $user_id;
    protected $logement_id;
    protected $created_at;

    // __construct
    public function __construct(int $user_id , int $logement_id) {
        $this->user_id = $user_id;
        $this->logement_id = $logement_id;
    }

    // Getters
    public function getUserId() { return $this->user_id; }
    public function getLogementId() { return $this->logement_id; }
    public function getCreatedAt() { return $this->created_at; }
}