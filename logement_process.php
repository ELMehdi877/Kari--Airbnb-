<?php
session_start();
require_once __DIR__ ."/config/database.php";
require_once __DIR__ ."/repositories/LogementRepository.php";
require_once __DIR__ ."/services/addLogementService.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
    exit;
}


// $id = (int) $_POST['id'] ?? null; 
$id = (int) ($_POST['id']);
$user_id = $_SESSION["user_id"];
$title = $_POST['title'] ?? null; 
$prix = $_POST['prix'] ?? null;
$description = $_POST['description'] ?? null;
$date_start = $_POST['date_start'] ?? null;
$date_end = $_POST['date_end'] ?? null;
$ville = $_POST['ville'] ?? null;

$image_path = NULL;



$pdo = Database::connect();
$logementRepo = new LogementRepository($pdo);
$logement = new LogementService($logementRepo);

//INSERT
if (isset($_POST["addLogement"])) {
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
    
        $imageName = time() . "_" . $_FILES["image"]["name"];
        $tmpName = $_FILES["image"]["tmp_name"];
        
        //dossier de destination
        $upload = __DIR__ . "/image/logement/";
        $destination = $upload . $imageName;
        $image_path = $imageName; 
        
        //deplacer l'image
        move_uploaded_file($tmpName, $destination);
    }
    $result = $logement->registerLogement($user_id,$title,$prix,$description,$date_start,$date_end,$ville,$image_path);
    $_SESSION["message"] = $result;
    header("Location: ./views/host-dashboard.php");
    exit;
}

//UPDATE
if (isset($_POST["updateLogement"])) {
    $result = $logement->updateLogementService($id,$user_id,$title,$prix,$description,$date_start,$date_end,$ville);
    $_SESSION["message"] = $result;
    header("Location: ./views/logementsHost.php");
    exit;
}

//DELETE

if (isset($_POST["deleteLogement"])) {
    $logement->deletelogementService($id);
    header("Location: ./views/logementsHost.php");
    exit;
}

