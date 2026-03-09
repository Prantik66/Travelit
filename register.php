<?php
session_start();

if(isset($_POST['register'])){

    $_SESSION['registered_email'] = $_POST['email'];
    $_SESSION['registered_password'] = $_POST['password'];
    $_SESSION['registered_name'] = $_POST['name'];

    echo "<script>
            alert('Registration successful. Please login.');
            window.location.href='login.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="register">Register</button>
</form>

</body>
</html>
