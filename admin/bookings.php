<?php
session_start();
require_once("../config/db.php");

if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit();
}

// Fetch all bookings
$bookings = $conn->query("
    SELECT b.id, b.user_name, b.user_email, b.user_phone, d.name AS destination, 
           p.days, p.transport, b.travel_date, b.num_people, b.total_price
    FROM bookings b
    JOIN packages p ON b.package_id = p.id
    JOIN destinations d ON p.destination_id = d.id
    ORDER BY b.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookings Log - Travelit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <h2>Bookings Log</h2>
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
                <td>₹<?= $row['total_price'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-light mt-3">Back to Dashboard</a>
</div>
</body>
</html>