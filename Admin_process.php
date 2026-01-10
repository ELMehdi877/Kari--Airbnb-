<?php
session_start();
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/repositories/AdminRepository.php";
require_once __DIR__ . "/services/AdminService.php"; 
// if ($_SERVICE["REQUEST_METHOD"] !== "POST") {
//     header("Location: ./index.html");
//     exit;
// }

$pdo = Database::connect();
$AdminRepo = new AdminRepository($pdo);
$serviceStatut = new AdminService($AdminRepo);


if (isset($_POST["button_desactive"]) || isset($_POST["button_active"])) {
    $value = (int) ($_POST["button_desactive"] ?? $_POST["button_active"]) ;
    $id = $_POST["user_id_statut"];
    $serviceStatut->serviceStatutAnnulation("user_logement_statut" , "users" , $value , $id);
    header("Location: ./views/administration/utilisateurs.php");
    exit;
}