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
$result = $userRepo->findByEmail($email);

if ($result) {
    if (password_verify($password,$result["password"])) {
        $_SESSION["message"] = "correct";
        header("Location: ./views/login.php");
        exit;
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