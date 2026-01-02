<?php 

class Logement {
    protected int $id;
    protected int $user_id;
    protected string $title;
    protected string $hote;
    protected float $prix;
    protected string $description;
    protected bool $statut;
    protected string $date_start;
    protected string $date_end;
    protected string $ville;
    protected string $created_at;
    
    // __construct
    public function __construct(int $id , int $user_id , string $title , string $hote , float $prix , string $description , bool $statut , string $date_start , string $date_end , string $ville){
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->hote = $hote;
        $this->prix = $prix;
        $this->description = $description;
        $this->statut = $statut;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->ville = $ville;
    }

    
    // Getters
    public function getUserId() { return $this->user_id; }
    public function getTitle() { return $this->title; }
    public function getHote() { return $this->hote; }
    public function getPrix() { return $this->prix; }
    public function getDescription() { return $this->description; }
    public function getStatut() { return $this->statut; }
    public function getDateStart() { return $this->date_start; }
    public function getDateEnd() { return $this->date_end; }
    public function getVille() { return $this->ville; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setStatut($statut) {
        $this->statut = $statut;
    }
} 