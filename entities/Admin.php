<?php
require_once "User.php";

class Hote extends User{
    public function getRole(){
        return "Admin";
    }
}