<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$travel_date = $_POST['travel_date'];
$num_people = $_POST['num_people'];

$mail = new PHPMailer(true);

try {

    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kesariyaprantik@gmail.com';
    $mail->Password = 'ADD_GOOGLE_INAPP_PASSWORD';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // sender
    $mail->setFrom('kesariyaprantik@gmail.com', 'Travelit');

    // receiver
    $mail->addAddress('kesariyaprantik@gmail.com');

    $mail->isHTML(true);

    $mail->Subject = 'New Travel Inquiry - Travelit';

    $mail->Body = "
        <h3>New Booking Response</h3>
        <b>Name:</b> $name <br>
        <b>Email:</b> $email <br>
        <b>Phone:</b> $phone <br>
        <b>Travel Date:</b> $travel_date <br>
        <b>People:</b> $num_people
    ";

    $mail->send();

    echo "success";

} catch (Exception $e) {

    echo "error";

}