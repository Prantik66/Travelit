<?php
session_start();
require_once("../config/db.php");

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($email == "admin@travelit.com" && $password == "admin123"){
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Travelit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark text-light d-flex align-items-center justify-content-center" style="min-height:100vh;">
<div class="card p-5 shadow-lg" style="width:400px; background:#111;">
    <h3 class="text-center mb-4">Admin Login</h3>
    <?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button class="btn btn-luxury w-100" name="login">Login</button>
    </form>
</div>
</body>
</html>