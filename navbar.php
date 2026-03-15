<?php session_start(); ?>

<header class="custom-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="index.php" class="logo" style="text-decoration:none;">Travelit</a>

        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="packages.php">Packages</a></li>
                <li><a href="index.php#contact">Contact</a></li>
            </ul>
        </nav>

        <div class="d-flex align-items-center gap-2 desktop-auth">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="text-light me-2" style="font-size:0.85rem;">Hi, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                <a href="logout.php" class="btn btn-sm btn-outline-secondary text-light">Logout</a>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === "admin"): ?>
                    <a href="admin/dashboard.php" class="btn btn-sm btn-luxury">Admin</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-light">Sign In</a>
                <a href="register.php" class="btn btn-sm btn-luxury">Register</a>
            <?php endif; ?>
        </div>

        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="packages.php">Packages</a></li>
            <li><a href="index.php#contact">Contact</a></li>
        </ul>
        <div class="auth-links">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-sm btn-outline-secondary text-light">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-light">Sign In</a>
                <a href="register.php" class="btn btn-sm btn-luxury">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var btn = document.getElementById("hamburgerBtn");
    if(btn) {
        btn.addEventListener("click", function() {
            document.getElementById("mobileMenu").classList.toggle("open");
        });
    }
});
</script>
