<?php
require_once __DIR__ . "/User.php";

class Voyageur extends User {
    public function getRole(){
        return "voyageur";
    }
}