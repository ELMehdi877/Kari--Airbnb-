<?php
session_start();
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/repositories/ReservationRepository.php";
require_once __DIR__ . "/services/ReservationService.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["user_id"])) {
    header("Location: ./index.html");
    exit;
}

$logement_id = $_POST['logement_id'] ;
$user_id = $_SESSION["user_id"];
$title = $_POST["title"];
$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];

$pdo = Database::connect();
$reservationRepo = new ReservationRepository($pdo);
$reservation = new ReservationService($reservationRepo);

//INSERT 
$result = $reservation->seveReservationService($title,$user_id,$logement_id,$date_start,$date_end);
$_SESSION["message"] = $result;

header("Location: ./views/index.php");
exit;