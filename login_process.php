<?php
session_start();
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/repositories/UserRepository.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}


$email = $_POST['email']; 

$password = $_POST['password'];
$pdo = Database::connect();
$userRepo = new UserRepository($pdo);
$result = $userRepo->find($email);

if ($result) {
    if (password_verify($password,$result["password"])) {
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["role"] = $result["role"];
        $_SESSION["statut"] = $result["statut"];

        if ($result["statut"] === 0) {
            $_SESSION["message"] = "Votre compte a été désactivé";
            header("Location: ./views/login.php");
            exit;
        }
        header("Location: ./views/index.php");
        exit;
        //     exit;
        // if ($result["role"] === "voyageur") {
        //     header("Location: ./views/index.php");
        //     exit;
        // }

        // if ($result["role"] === "hote") {
        //     header("Location: ./views/host-dashboard.php");
        //     exit;
        // }
    }
    else {
        $_SESSION["message"] = "incorrect";
        header("Location: ./views/login.php");
        exit;
    }
}
else {
    $_SESSION["message"] = "ce compte n'existe pas";
        header("Location: ./views/login.php");
        exit;
}