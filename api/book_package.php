<?php
require_once("../config/db.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

header("Content-Type: application/json");

// Check request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

// Check login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Please login first."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$package_id = intval($_POST['package_id']);
$travel_date = $_POST['travel_date'];
$num_people = intval($_POST['num_people']);

// Validate travel date
if ($travel_date < date("Y-m-d")) {
    echo json_encode(["status" => "error", "message" => "Invalid travel date"]);
    exit();
}

// Fetch package
$pkg_result = $conn->query("SELECT p.days, p.transport, p.price, d.name AS destination 
                            FROM packages p 
                            JOIN destinations d ON p.destination_id=d.id 
                            WHERE p.id = $package_id");
$pkg = $pkg_result->fetch_assoc();

if (!$pkg) {
    echo json_encode(["status" => "error", "message" => "Invalid package"]);
    exit();
}

// Fetch user info
$user_result = $conn->query("SELECT name, email, phone FROM users WHERE id = $user_id");
$user = $user_result->fetch_assoc();

if (!$user) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit();
}

// Prepare insert
$total_price = $pkg['price'] * $num_people;
$status = 'pending_payment';

$stmt = $conn->prepare("INSERT INTO bookings 
    (user_id, user_name, user_email, user_phone, package_id, travel_date, num_people, total_price, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
    exit();
}

$stmt->bind_param(
    "isssisids",
    $user_id,
    $user['name'],
    $user['email'],
    $user['phone'],
    $package_id,
    $travel_date,
    $num_people,
    $total_price,
    $status
);

if (!$stmt->execute()) {
    echo json_encode(["status" => "error", "message" => "Execute failed: " . $stmt->error]);
    exit();
}

$booking_id = $stmt->insert_id;

// Send email to admin
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kesariyaprantik@gmail.com';
    $mail->Password = 'GOOGLE IN APP PASSWORD'; // app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('kesariyaprantik@gmail.com', 'Travelit');
    $mail->addAddress('kesariyaprantik@gmail.com'); // admin email

    $mail->isHTML(true);
    $mail->Subject = "New Booking Request - Travelit";
    $mail->Body = "
        <h3>Booking Request #$booking_id</h3>
        <b>Name:</b> {$user['name']}<br>
        <b>Email:</b> {$user['email']}<br>
        <b>Phone:</b> {$user['phone']}<br>
        <b>Travel Date:</b> $travel_date<br>
        <b>People:</b> $num_people<br>
        <b>Package:</b> {$pkg['destination']} ({$pkg['days']} / {$pkg['transport']})<br>
        <b>Total Price:</b> ₹$total_price
    ";
    $mail->send();

    echo json_encode(["status" => "success", "message" => "Booking successful! Admin has been notified."]);
} catch (Exception $e) {
    echo json_encode(["status" => "success", "message" => "Booking successful! Email failed: {$mail->ErrorInfo}"]);
}
?>