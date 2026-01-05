<?php 

class Database{
    // methode statique pour connexion avec database
    public static function connect(){
        $pdo = new PDO("mysql:host=localhost;dbname=KARI;charset=utf8","root","");
        return $pdo;
    }
}
