<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Travelit</title>
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
        .stat-card {
            background: #111;
            border: 1px solid #1e1e1e;
            border-radius: 16px;
            padding: 28px;
            text-align: center;
            transition: transform 0.3s, border-color 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(197,164,126,0.3);
        }
        .stat-card .icon {
            font-size: 2rem;
            margin-bottom: 12px;
        }
        .stat-card h5 {
            color: #c5a47e;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .stat-card p {
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 16px;
        }
        .btn-panel {
            background: linear-gradient(135deg,#c5a47e,#a8845a);
            color: #000;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-panel:hover {
            background: linear-gradient(135deg,#d4b896,#c5a47e);
            color: #000;
            transform: translateY(-1px);
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
            <a href="bookings.php"><i class="fa fa-calendar-check"></i> Bookings</a>
            <a href="logout.php" style="color:#e74c3c;"><i class="fa fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 style="font-weight:700; margin-bottom:6px;">Welcome to Admin Panel</h2>
    <p style="color:#666; margin-bottom:40px;">Manage bookings, packages, and user feedback from here.</p>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon">💬</div>
                <h5>Feedback</h5>
                <p>View all user feedback and ratings submitted.</p>
                <a href="feedback.php" class="btn-panel">View Feedback</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon">🧳</div>
                <h5>Packages</h5>
                <p>Add, edit, or remove travel packages and pricing.</p>
                <a href="packages.php" class="btn-panel">Manage Packages</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon">📋</div>
                <h5>Bookings</h5>
                <p>View all customer bookings and contact details.</p>
                <a href="bookings.php" class="btn-panel">View Bookings</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>