<?php
session_start();
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/repositories/FavorisRepository.php";
require_once __DIR__ . "/services/FavorisService.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["user_id"])) {
    header("Location: ./index.html");
    exit;
}


$pdo = Database::connect();
$reservationRepo = new FavorisRepository($pdo);
$favoris = new FavorisService($reservationRepo);

//INSERT 
if (isset($_POST["ajoute_favoris"])) {
    $logement_id = $_POST['logement_id'] ;
    $user_id = $_SESSION["user_id"];
    $result = $favoris->seveFavorisService($user_id,$logement_id);
}

if (isset($_POST["delete_favoris"])) {
    $favoris_id = (int) ($_POST["favoris_id"]);
    $favoris->deleteFavorisService($favoris_id);
}

header("Location: ./views/favoris.php");
exit;