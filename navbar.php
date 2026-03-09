<?php
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Travelit</a>

    <div>
      <a class="nav-link d-inline text-light me-3" href="index.php">Home</a>
      <a class="nav-link d-inline text-light me-3" href="feedback.php">Feedback</a>

      <?php if(isset($_SESSION['user_id'])): ?>

        <span class="text-light me-3">
            Welcome, <?php echo $_SESSION['user_name'] ?? 'User'; ?>
        </span>

        <a class="btn btn-danger" href="logout.php">Logout</a>

      <?php else: ?>

        <a class="btn btn-primary me-2" href="login.php">Login</a>
        <a class="btn btn-outline-light" href="register.php">Register</a>

      <?php endif; ?>

    </div>
  </div>
</nav>
