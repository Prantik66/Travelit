<?php
session_start();
require_once("../config/db.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit();
}

// Update booking status
if(isset($_POST['update_status'])){
    $id = $_POST['booking_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    // Send email to guest if status changed
    $booking = $conn->query("SELECT * FROM bookings WHERE id=$id")->fetch_assoc();
    $user_email = $booking['user_email'];
    $user_name = $booking['user_name'];
    $pkg_info = $conn->query("SELECT d.name AS destination, p.days, p.transport, p.price
                              FROM packages p 
                              JOIN destinations d ON p.destination_id=d.id 
                              WHERE p.id={$booking['package_id']}")->fetch_assoc();
    if($user_email && ($status=='confirmed' || $status=='cancelled')) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kesariyaprantik@gmail.com';
            $mail->Password = 'mnqneczjqajvgrzs'; // your app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('kesariyaprantik@gmail.com', 'Travelit');
            $mail->addAddress($user_email, $user_name);

            $mail->isHTML(true);
            $mail->Subject = "Your Booking Status - Travelit";

            if($status == 'confirmed'){
                $mail->Body = "
                    <h3>Booking Confirmed!</h3>
                    <b>Package:</b> {$pkg_info['destination']} ({$pkg_info['days']} / {$pkg_info['transport']})<br>
                    <b>Travel Date:</b> {$booking['travel_date']}<br>
                    <b>People:</b> {$booking['num_people']}<br>
                    <b>Total Price:</b> ₹{$booking['total_price']}<br>
                    Please proceed with the payment as discussed.
                ";
            } else {
                $mail->Body = "<h3>Booking Cancelled</h3><p>Unfortunately, your booking has been cancelled. Please contact us for details.</p>";
            }

            $mail->send();
            // success message
            echo "Email sent successfully to $user_email";
        } catch (Exception $e) {
            // show error
            echo "Mailer Error: " . $mail->ErrorInfo;
            exit; // stop redirect to see error
        }
    }

    header("Location: bookings.php");
    exit();
}

// Fetch bookings for admin panel
$bookings = $conn->query("
    SELECT b.id, b.user_name, b.user_email, b.user_phone, d.name AS destination, 
           p.days, p.transport, b.travel_date, b.num_people, b.total_price, b.status
    FROM bookings b
    JOIN packages p ON b.package_id = p.id
    JOIN destinations d ON p.destination_id = d.id
    ORDER BY b.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookings - Travelit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <h2>Bookings</h2>

    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Destination</th>
                <th>Package</th>
                <th>Travel Date</th>
                <th>People</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $bookings->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_name'] ?></td>
                <td><?= $row['user_email'] ?></td>
                <td><?= $row['user_phone'] ?></td>
                <td><?= $row['destination'] ?></td>
                <td><?= $row['days'] ?> / <?= $row['transport'] ?></td>
                <td><?= $row['travel_date'] ?></td>
                <td><?= $row['num_people'] ?></td>
                <td><?= $row['total_price'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <form method="POST" class="d-flex">
                        <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                        <select name="status" class="form-select form-select-sm me-1">
                            <option value="pending_payment" <?= $row['status']=='pending_payment'?'selected':'' ?>>Pending</option>
                            <option value="confirmed" <?= $row['status']=='confirmed'?'selected':'' ?>>Confirmed</option>
                            <option value="cancelled" <?= $row['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-success btn-sm">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-light mt-3">Back to Dashboard</a>
</div>
</body>
</html>