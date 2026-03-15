<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sign in to your Travelit account to manage bookings and explore packages.">
    <title>Travelit — Sign In</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background:
                linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                url("https://images.unsplash.com/photo-1561131668-f63504fc549d?q=80&w=1157&auto=format&fit=crop");
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .auth-card {
            max-width: 460px;
            width: 100%;
            background: rgba(5, 5, 5, 0.88);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 44px 40px;
            box-shadow: 0 30px 70px rgba(0,0,0,0.9);
            border: 1px solid rgba(197,164,126,0.15);
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-name {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 3px;
            color: #c5a47e;
            text-transform: uppercase;
        }

        .brand-sub {
            color: #888;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        h2 {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 24px;
            text-align: center;
        }

        .form-label {
            color: #aaa;
            font-size: 0.82rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-text {
            background: #111;
            border: 1px solid #2a2a2a;
            border-right: none;
            color: #c5a47e;
        }

        .form-control {
            background: #111;
            border: 1px solid #2a2a2a;
            color: #fff;
            border-left: none;
            font-size: 0.9rem;
            padding: 10px 14px;
        }

        .form-control:focus {
            background: #111;
            border-color: #c5a47e;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(197,164,126,0.15);
        }

        .btn-auth {
            background: linear-gradient(135deg, #c5a47e, #a8845a);
            color: #000;
            border: none;
            padding: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 10px;
            width: 100%;
            margin-top: 8px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-auth:hover {
            background: linear-gradient(135deg, #d4b896, #c5a47e);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(197,164,126,0.35);
        }

        .auth-link {
            text-align: center;
            margin-top: 20px;
            color: #777;
            font-size: 0.87rem;
        }

        .auth-link a {
            color: #c5a47e;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 12px;
        }

        .back-home a {
            color: #555;
            font-size: 0.82rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-home a:hover {
            color: #c5a47e;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="auth-card">

    <div class="brand">
        <div class="brand-name">Travelit</div>
        <div class="brand-sub">Discover India's finest destinations</div>
    </div>

    <h2>Welcome Back</h2>

    <form id="loginForm">
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn-auth">Sign In</button>
    </form>

    <div id="loginMsg" class="text-center mt-3 small"></div>

    <div class="auth-link">
        Don't have an account? <a href="register.php">Register for free</a>
    </div>

    <div class="back-home">
        <a href="index.php"><i class="fa fa-arrow-left"></i> Back to Home</a>
    </div>

</div>

<script>
$("#loginForm").submit(function(e) {
    e.preventDefault();

    let btn = $(this).find("button[type=submit]");
    btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Signing in...').prop("disabled", true);

    $.ajax({
        url: "api/login_user.php",
        method: "POST",
        data: $(this).serialize(),
        success: function(response) {
            if(response === "success") {
                window.location = "index.php";
            } else {
                $("#loginMsg").html("<span class='text-danger'>" + response + "</span>");
                btn.html("Sign In").prop("disabled", false);
            }
        },
        error: function() {
            $("#loginMsg").html("<span class='text-danger'>Something went wrong. Try again.</span>");
            btn.html("Sign In").prop("disabled", false);
        }
    });
});
</script>

</body>
</html>