<?php
session_start();
require_once  __DIR__ ."/config/database.php";
require_once  __DIR__ ."/services/UserService.php";

// if ($_SERVER["REQUEST_METHOD"] === "POST" || !isset($_SESSION["user_id"]) || !isset($_POST["update_profile"])) {
//     header("Location: ./index.html");
//     exit;
// }

$user_id = $_SESSION["user_id"];
$fullname = $_POST["fullname"];
$email = $_POST["email"];
$password = password_hash($_POST["new_password"] , PASSWORD_DEFAULT);
$pdo = DATABASE::connect();
$repo = new UserRepository($pdo);
$info = new UserService($repo);
if (!empty($_FILES["photo"]) && $_FILES["photo"]["error"] === 0) {
    
        $imageName = time() . "_" . $_FILES["photo"]["name"];
        $tmpName = $_FILES["photo"]["tmp_name"];
        
        //dossier de destination
        $upload = __DIR__ . "/image/profile/";
        $destination = $upload . $imageName;
        $photo = $imageName; 
        
        //deplacer l'image
        move_uploaded_file($tmpName, $destination);
    }
else {
    $photo = $_POST["photo_hidden"];
}
$resul = $info->updateInfoUserService($photo , $fullname , $email , $password , $user_id);
$_SESSION["info"] = $resul;
header("Location: ./views/profil.php");
exit;