<?php
abstract class User{
    protected  int $id;
    protected  string $fullname;
    protected  string $email;
    protected  string $password;
    protected string $statut;
    protected  string $created_at;

    // __construct
    public function __construct(string $fullname, string $email, string $password){
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->statut = true;
    }

    // Getters
    public function getId(){ return $this->id; }
    public function getFullname(){ return $this->fullname; }
    public function getEmail(){ return $this->email; }
    public function getPassword(){ return $this->password; }
    public function getStatut(){ return $this->statut; }
    
    // Setters
    public function setId(int $id){ $this->id = $id; }
    public function setFullname($fullname) { $this->fullname = $fullname; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }
    public function setStatut($statut) { $this->statut = $statut; }
    public function setRole($role) { $this->role = $role; }

    //abstract 
    abstract public function getRole();
}