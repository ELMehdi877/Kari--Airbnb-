<?php
session_start();
require_once __DIR__ .'/config/database.php';
require_once __DIR__ . '/entities/User.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/services/AdminService.php';
require_once __DIR__ . '/services/HoteService.php';
require_once __DIR__ . '/services/VoyageurService.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$fullname = $_POST['fullname'];
$email = $_POST['email']; 
$role = $_POST['role'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$pdo = Database::connect();
$userRepo = new UserRepository($pdo);


if ($role === "admin") {
    $admin = new AdminService($userRepo);
    $result = $admin->registerAdmin($fullname,$email,$password);
    $_SESSION["message"] = $result;
    header('Location: ./views/register.php');
    exit;
}

if ($role === "Hote") {
    $voyserver = new HoteService($userRepo);
    $result = $voyserver->registerHote($fullname,$email,$password);
    $_SESSION["message"] = $result;
    header('Location: ./views/register.php');
    exit;
}

if ($role === "voyageur") {
    $voyserver = new VoyageurService($userRepo);
    $result = $voyserver->registerVoyageur($fullname,$email,$password);
    $_SESSION["message"] = $result;
    header('Location: ./views/register.php');
    exit;
}