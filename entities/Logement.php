<?php 

class Logement {
    protected int $id;
    protected int $user_id;
    protected string $title;
    protected float $prix;
    protected string $description;
    protected bool $statut;
    protected string $date_start;
    protected string $date_end;
    protected string $ville;
    protected string $image_path;
    protected string $created_at;
    
    // __construct
    public function __construct(int $user_id , string $title , float $prix , string $description , string $ville , string $image_path){
        $this->user_id = $user_id;
        $this->title = $title;
        $this->prix = $prix;
        $this->description = $description;
        $this->statut = true;
        $this->ville = $ville;
        $this->image_path = $image_path;
    }

    
    // Getters
    public function getUserId() { return $this->user_id; }
    public function getTitle() { return $this->title; }
    public function getPrix() { return $this->prix; }
    public function getDescription() { return $this->description; }
    public function getStatut() { return $this->statut; }
    public function getVille() { return $this->ville; }
    public function getImage_path() { return $this->image_path; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setStatut($statut) {
        $this->statut = $statut;
    }
} 