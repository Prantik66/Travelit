<?php
session_start();

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Travelit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark text-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Travelit Admin</a>
        <div>
            <a href="dashboard.php" class="btn btn-outline-light me-2">Dashboard</a>
            <a href="feedback.php" class="btn btn-outline-light me-2">Feedback</a>
            <a href="packages.php" class="btn btn-outline-light me-2">Packages</a>
            <a href="bookings.php" class="btn btn-outline-light me-2">Bookings</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Welcome to Travelit Admin Panel</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-dark bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Feedback</h5>
                    <p class="card-text">View user feedback submissions.</p>
                    <a href="feedback.php" class="btn btn-dark">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Packages</h5>
                    <p class="card-text">Add, edit, or remove travel packages.</p>
                    <a href="packages.php" class="btn btn-dark">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Bookings</h5>
                    <p class="card-text">View all user bookings.</p>
                    <a href="bookings.php" class="btn btn-dark">View</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>