<?php
session_start();
require_once __DIR__ . "/repositories/AdminRepository";
require_once __DIR__ . "/service/AdminService.php";
if ($_SERVICE["REQUEST_METHOD"] !== "POST") {
    header("Location: ./index.html");
    exit;
}