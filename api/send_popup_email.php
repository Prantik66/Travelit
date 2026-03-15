<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$name        = trim($_POST['name'] ?? '');
$email       = trim($_POST['email'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$travel_date = trim($_POST['travel_date'] ?? '');
$num_people  = intval($_POST['num_people'] ?? 0);

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kesariyaprantik@gmail.com';
    $mail->Password   = 'IN_APP_PASS';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('kesariyaprantik@gmail.com', 'Travelit');
    $mail->addAddress('kesariyaprantik@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'New Travel Inquiry — Travelit';
    $mail->Body = "
        <div style='font-family:Arial,sans-serif; max-width:500px;'>
            <h2 style='color:#c5a47e;'>New Travel Inquiry</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Travel Date:</strong> $travel_date</p>
            <p><strong>People:</strong> $num_people</p>
        </div>
    ";

    $mail->send();
    echo "success";

} catch (Exception $e) {
    echo "error";
}
?>