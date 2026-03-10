<?php
require_once("../config/db.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status"=>"error","message"=>"Invalid request"]);
    exit();
}

// Collect form data from modal
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$travel_date = $_POST['travel_date'];
$num_people = intval($_POST['num_people']);
$package_id = intval($_POST['package_id']);

// Fetch package info
$pkg = $conn->query("SELECT d.name AS destination, p.days, p.transport, p.price 
                     FROM packages p 
                     JOIN destinations d ON p.destination_id=d.id 
                     WHERE p.id=$package_id")->fetch_assoc();

if (!$pkg) {
    echo json_encode(["status"=>"error","message"=>"Invalid package"]);
    exit();
}

$total_price = $pkg['price'] * $num_people;
$status = 'pending'; // optional, just for log
$user_id = 0; // since no login required

// Insert booking into DB
$stmt = $conn->prepare("INSERT INTO bookings 
    (user_id, user_name, user_email, user_phone, package_id, travel_date, num_people, total_price, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssisids", $user_id, $name, $email, $phone, $package_id, $travel_date, $num_people, $total_price, $status);

if (!$stmt->execute()) {
    echo json_encode(["status"=>"error","message"=>"Booking failed: ".$stmt->error]);
    exit();
}

// Send email to admin
$booking_id = $stmt->insert_id;
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kesariyaprantik@gmail.com';
    $mail->Password = 'mnqneczjqajvgrzs';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('kesariyaprantik@gmail.com', 'Travelit');
    $mail->addAddress('kesariyaprantik@gmail.com'); // admin

    $mail->isHTML(true);
    $mail->Subject = "New Booking Request #$booking_id - Travelit";
    $mail->Body = "
        <h3>Booking Request</h3>
        <b>Name:</b> $name<br>
        <b>Email:</b> $email<br>
        <b>Phone:</b> $phone<br>
        <b>Travel Date:</b> $travel_date<br>
        <b>People:</b> $num_people<br>
        <b>Package:</b> {$pkg['destination']} ({$pkg['days']} / {$pkg['transport']})<br>
        <b>Total Price:</b> ₹$total_price
    ";
    $mail->send();

    echo json_encode(["status"=>"success","message"=>"Booking successful! Admin has been notified."]);
} catch (Exception $e) {
    echo json_encode(["status"=>"success","message"=>"Booking logged but failed to send email: ".$mail->ErrorInfo]);
}
?>