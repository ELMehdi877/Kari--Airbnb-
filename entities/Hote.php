<?php
require_once __DIR__ . "/User.php";

class Hote extends User{
    public function getRole(){
        return "Hote";
    }
} 