<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    session_destroy();
    header("Location: ./../index.html");
    exit;
}
else {
    header("Location: ./../index.html");
    exit();
}