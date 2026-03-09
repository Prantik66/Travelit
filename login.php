<?php
session_start();

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(
        isset($_SESSION['registered_email']) &&
        $email == $_SESSION['registered_email'] &&
        $password == $_SESSION['registered_password']
    ){

        $_SESSION['user_id'] = 1;
        $_SESSION['user_name'] = $_SESSION['registered_name'];

        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>

<p>Don't have an account? <a href="register.php">Register here</a></p>

</body>
</html>
