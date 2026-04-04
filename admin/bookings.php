<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

/* status update */
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if($action == "confirm"){
        $conn->query("UPDATE bookings SET status='confirmed' WHERE id=$id");
    }

    if($action == "cancel"){
        $conn->query("UPDATE bookings SET status='cancelled' WHERE id=$id");
    }

    header("Location: bookings.php");
    exit();
}

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
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bookings Log - Travelit Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background: #050505;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
}
.admin-nav {
    background: #0a0a0a;
    border-bottom: 1px solid rgba(197,164,126,0.15);
    padding: 16px 0;
}
.admin-brand {
    font-weight: 700;
    letter-spacing: 2px;
    color: #c5a47e;
    font-size: 1.2rem;
}
.admin-nav a {
    color: #aaa;
    text-decoration: none;
    transition: color 0.3s;
    font-size: 0.9rem;
}
.admin-nav a:hover {
    color: #c5a47e;
}
.table-wrap {
    background: #111;
    border-radius: 16px;
    overflow-x: auto;
    border: 1px solid #1e1e1e;
}
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
}
th {
    background: #0a0a0a;
    color: #c5a47e;
    padding: 14px 16px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.78rem;
    letter-spacing: 0.5px;
    white-space: nowrap;
}
td {
    padding: 13px 16px;
    border-top: 1px solid #1a1a1a;
    color: #ccc;
    white-space: nowrap;
}
tr:hover td {
    background: #161616;
}
.price-cell {
    color: #c5a47e;
    font-weight: 600;
}
.status-badge {
    background: rgba(197,164,126,0.15);
    color: #c5a47e;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}
.btn-back {
    background: linear-gradient(135deg,#c5a47e,#a8845a);
    color: #000;
    border: none;
    border-radius: 8px;
    padding: 10px 22px;
    font-weight: 600;
    font-size: 0.85rem;
    text-decoration: none;
}
.btn-back:hover {
    background: linear-gradient(135deg,#d4b896,#c5a47e);
    color: #000;
}
</style>
</head>

<body>

<nav class="admin-nav">
<div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
<span class="admin-brand">Travelit Admin</span>

<div class="d-flex gap-3 flex-wrap align-items-center">
<a href="dashboard.php"><i class="fa fa-gauge"></i> Dashboard</a>
<a href="feedback.php"><i class="fa fa-comments"></i> Feedback</a>
<a href="packages.php"><i class="fa fa-suitcase"></i> Packages</a>
<a href="bookings.php" style="color:#c5a47e;"><i class="fa fa-calendar-check"></i> Bookings</a>
<a href="logout.php" style="color:#e74c3c;"><i class="fa fa-right-from-bracket"></i> Logout</a>
</div>

</div>
</nav>

<div class="container mt-5 mb-5">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
<div>
<h2 style="font-weight:700; margin-bottom:4px;">Bookings Log</h2>
<p style="color:#666; font-size:0.9rem; margin:0;">All customer booking requests</p>
</div>

<a href="dashboard.php" class="btn-back"><i class="fa fa-arrow-left"></i> Dashboard</a>
</div>

<div class="table-wrap">

<table>

<thead>
<tr>
<th>#</th>
<th>Customer</th>
<th>Email</th>
<th>Phone</th>
<th>Destination</th>
<th>Duration</th>
<th>Transport</th>
<th>Travel Date</th>
<th>People</th>
<th>Total</th>
<th>Status</th>
<th>Action</th> <!-- ADDED -->
</tr>
</thead>

<tbody>

<?php while($row = $bookings->fetch_assoc()): ?>
<tr>

<td><?= htmlspecialchars($row['id']) ?></td>
<td><?= htmlspecialchars($row['user_name']) ?></td>
<td><?= htmlspecialchars($row['user_email']) ?></td>
<td><?= htmlspecialchars($row['user_phone']) ?></td>
<td><?= htmlspecialchars($row['destination']) ?></td>
<td><?= htmlspecialchars($row['days']) ?></td>
<td><?= htmlspecialchars($row['transport']) ?></td>
<td><?= htmlspecialchars($row['travel_date']) ?></td>
<td><?= htmlspecialchars($row['num_people']) ?></td>

<td class="price-cell">
₹<?= number_format($row['total_price']) ?>
</td>

<td>
<span class="status-badge">
<?= htmlspecialchars($row['status'] ?? 'pending') ?>
</span>
</td>

<td> 

<?php if($row['status'] != 'confirmed'): ?>
<a href="bookings.php?action=confirm&id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Confirm</a>
<?php endif; ?>

<?php if($row['status'] != 'cancelled'): ?>
<a href="bookings.php?action=cancel&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Cancel</a>
<?php endif; ?>

</td>

</tr>
<?php endwhile; ?>

</tbody>
</table>

</div>
</div>

</body>
</html>