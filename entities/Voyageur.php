<?php
require_once "User.php";

class Voyageur extends User {
    public function getRole(){
        return "voyageur";
    }
}