<?php
session_start();
require_once __DIR__ ."/config/database.php";
require_once __DIR__ ."/repositories/LogementRepository.php";
require_once __DIR__ ."/services/addLogementService.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
    exit;
}



$user_id = $_SESSION["user_id"];
$title = $_POST['title']; 
$prix = $_POST['prix'];
$description = $_POST['description'];
$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];
$ville = $_POST['ville'];

$image_path = NULL;
if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {

    $imageName = time() . "_" . $_FILES["image"]["name"];
    $tmpName = $_FILES["image"]["tmp_name"];
    
    //dossier de destination
    $upload = __DIR__ . "/image/logement/";
    $destination = $upload . $imageName;
    $image_path = $destination; 
    
    //deplacer l'image
    move_uploaded_file($tmpName, $destination);
}
else {
    header("Location: ./views/host-dashboard.php");
    exit;
}

$pdo = Database::connect();
$logementRepo = new LogementRepository($pdo);
$logement = new LogementService($logementRepo);

$result = $logement->registerLogement($user_id,$title,$prix,$description,$date_start,$date_end,$ville,$image_path);

$_SESSION["message"] = $result;
header("Location: ./views/host-dashboard.php");
exit;