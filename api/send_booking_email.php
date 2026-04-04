<?php
require_once("../config/db.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}

$name           = trim($_POST['name'] ?? '');
$email          = trim($_POST['email'] ?? '');
$phone          = trim($_POST['phone'] ?? '');
$travel_date    = trim($_POST['travel_date'] ?? '');
$num_people     = intval($_POST['num_people'] ?? 0);
$package_id     = intval($_POST['package_id'] ?? 0);
$payment_method = trim($_POST['payment_method'] ?? 'card');

if (!$name || !$email || !$phone || !$travel_date || $num_people < 1 || $package_id < 1) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit();
}

$result = $conn->query("SELECT d.name AS destination, p.days, p.transport, p.price
                         FROM packages p
                         JOIN destinations d ON p.destination_id = d.id
                         WHERE p.id = $package_id");
$pkg = $result ? $result->fetch_assoc() : null;

if (!$pkg) {
    echo json_encode(["status" => "error", "message" => "Package not found"]);
    exit();
}

$total_price = $pkg['price'] * $num_people;
$status = 'pending';
$user_id = 0;

$stmt = $conn->prepare("INSERT INTO bookings
    (user_id, user_name, user_email, user_phone, package_id, travel_date, num_people, total_price, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssisids", $user_id, $name, $email, $phone, $package_id, $travel_date, $num_people, $total_price, $status);

if (!$stmt->execute()) {
    echo json_encode(["status" => "error", "message" => "Booking failed: " . $stmt->error]);
    exit();
}

$booking_id = $stmt->insert_id;
$payment_label = ucfirst($payment_method);

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kesariyaprantik@gmail.com';
    $mail->Password   = 'xromjgeetutltedq';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('kesariyaprantik@gmail.com', 'Travelit Bookings');
    $mail->addAddress('kesariyaprantik@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = "New Booking #$booking_id — Travelit";
    $mail->Body = "
        <div style='font-family:Poppins,Arial,sans-serif; max-width:600px; margin:auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.1);'>
            <div style='background:linear-gradient(135deg,#c5a47e,#a8845a); padding:30px 24px; text-align:center;'>
                <h1 style='color:#000; margin:0; font-size:1.8rem; letter-spacing:2px;'>TRAVELIT</h1>
                <p style='color:#000; opacity:0.7; margin:6px 0 0; font-size:0.9rem;'>New Booking Request</p>
            </div>
            <div style='padding:30px 24px;'>
                <h2 style='color:#333; font-size:1.1rem; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #f0e8d8;'>
                    Booking #$booking_id — Action Required
                </h2>
                <table style='width:100%; border-collapse:collapse;'>
                    <tr style='background:#fdf8f2;'>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem; width:40%;'>Customer Name</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>$name</td>
                    </tr>
                    <tr>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Email</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>$email</td>
                    </tr>
                    <tr style='background:#fdf8f2;'>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Phone</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>$phone</td>
                    </tr>
                    <tr>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Destination</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>{$pkg['destination']}</td>
                    </tr>
                    <tr style='background:#fdf8f2;'>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Duration</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>{$pkg['days']}</td>
                    </tr>
                    <tr>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Transport</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>{$pkg['transport']}</td>
                    </tr>
                    <tr style='background:#fdf8f2;'>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Travel Date</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>$travel_date</td>
                    </tr>
                    <tr>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Travelers</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>$num_people person(s)</td>
                    </tr>
                    <tr style='background:#fdf8f2;'>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Payment Method</td>
                        <td style='padding:10px 14px; color:#333; font-weight:600;'>$payment_label (Mock)</td>
                    </tr>
                    <tr>
                        <td style='padding:10px 14px; color:#888; font-size:0.85rem;'>Total Amount</td>
                        <td style='padding:10px 14px; color:#c5a47e; font-weight:700; font-size:1.1rem;'>₹$total_price</td>
                    </tr>
                </table>
                <div style='margin-top:24px; padding:16px; background:#fdf8f2; border-left:4px solid #c5a47e; border-radius:6px;'>
                    <strong style='color:#333;'>Next Step:</strong>
                    <p style='color:#555; margin:6px 0 0; font-size:0.9rem;'>Please contact <strong>$name</strong> at <strong>$email</strong> or <strong>$phone</strong> to confirm their booking and share itinerary details.</p>
                </div>
            </div>
            <div style='background:#f9f9f9; padding:16px; text-align:center; border-top:1px solid #eee;'>
                <p style='color:#aaa; font-size:0.78rem; margin:0;'>© 2026 Travelit &bull; Booking ID: #$booking_id</p>
            </div>
        </div>
    ";

    $mail->send();
    echo json_encode(["status" => "success", "message" => "Booking confirmed. Admin has been notified.", "booking_id" => $booking_id]);

} catch (Exception $e) {
    echo json_encode(["status" => "success", "message" => "Booking logged. Admin notification pending.", "booking_id" => $booking_id]);
}
?>