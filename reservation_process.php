<?php
session_start();
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/repositories/ReservationRepository.php";
require_once __DIR__ . "/services/ReservationService.php";

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["user_id"])) {
    header("Location: ./index.html");
    exit;
}


$pdo = Database::connect();
$reservationRepo = new ReservationRepository($pdo);
$reservation = new ReservationService($reservationRepo);

$email_hote = $_POST["email"];
//INSERT 
if (isset($_POST["ajoute_reservation"])) {
    $logement_id = $_POST['logement_id'] ;
    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $result = $reservation->seveReservationService($title,$user_id,$logement_id,$date_start,$date_end);
    $_SESSION["message"] = $result;
    $message_voyageur = $result;
    $message_hote = $_SESSION["fullname"]." a été reserver le logement : ".$title;


}

if (isset($_POST["delete_reservation"])) {
    $reservation_id = $_POST["delete_reservation"];
    $title = $_POST["title"];
    $result = $reservation->deleteReservationService($reservation_id,$title);
    $message_voyageur = $result;
    $message_hote = $_SESSION["fullname"]." a été annulé la reseration de le logement : ".$title;

}

$emails = [
    ['email' => $email_hote, 'message' => $message_hote],
    ['email' => $_SESSION["email"], 'message' => $message_voyageur],
];
foreach($emails as $email){
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('EMAILS');
        $mail->Password   = getenv('PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Email settings
        $mail->setFrom(getenv('EMAILS'), 'Airbnb');
        $mail->addAddress($email["email"]);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Annonce de reservation';
        $mail->Body    = "
                        <p>Hello</p>
                        <h2>{$email['message']}</h2>
                    ";

        $mail->AltBody = $email["message"];

        $mail->send();

    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}
header("Location: ./views/index.php");
exit;