<?php
session_start();
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/repositories/AdminRepository.php";
require_once __DIR__ . "/services/AdminService.php"; 

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["user_id"])) {
    header("Location: ./index.html");
    exit;
}

$pdo = Database::connect();
$AdminRepo = new AdminRepository($pdo);
$serviceStatut = new AdminService($AdminRepo);


if (isset($_POST["button_desactive"]) || isset($_POST["button_active"])) {
    
    if (isset($_POST["user_id_statut"])) {
        $id = $_POST["user_id_statut"];
        $value = (int) ($_POST["button_desactive"] ?? $_POST["button_active"]) ;
        $serviceStatut->serviceStatut("users" , $value , $id);
        header("Location: ./views/administration/utilisateurs.php");
        exit;
        
    }
    elseif (isset($_POST["logement_id_statut"])) {
        $id = $_POST["logement_id_statut"];
        $value = (int) ($_POST["button_desactive"] ?? $_POST["button_active"]) ;
        $serviceStatut->serviceStatut("logements" , $value , $id);
        if (isset($_POST["dashboard"])) {
            header("Location: ./views/administration/dashboard.php");
            exit;
        }
        header("Location: ./views/administration/logements.php");
        exit;
    }
}

if (isset($_POST["annulation"])) {
    $id = $_POST["annulation"];
    $serviceStatut->serviceAnnulation($id);
    header("Location: ./views/administration/annulations.php");
    exit;
}