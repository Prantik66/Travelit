<!DOCTYPE html>
<html>
<head>

<title>Travelit - Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>

/* Premium background */
body{
    min-height:100vh;
    background:
    linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),
    url("https://images.unsplash.com/photo-1561131668-f63504fc549d?q=80&w=1157&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
    background-size:cover;
    background-position:center;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* Glass card */
.auth-card{
    max-width:500px;
    width:100%;
    background:rgba(0,0,0,0.75);
    backdrop-filter:blur(10px);
    border-radius:12px;
    padding:40px;
    box-shadow:0 20px 50px rgba(0,0,0,0.8);
    border:1px solid rgba(255,255,255,0.1);
}

</style>

</head>
<body>

<div class="auth-card">

<h2 class="text-center mb-4 text-light">Create Account</h2>

<form id="registerForm">

<div class="mb-3">
<input type="text" name="name" class="form-control" placeholder="Full Name" required>
</div>

<div class="mb-3">
<input type="email" name="email" class="form-control" placeholder="Email" required>
</div>

<div class="mb-3">
<input type="password" name="password" class="form-control" placeholder="Password" required>
</div>

<button class="btn btn-luxury w-100">Register</button>

</form>

<div id="registerMsg" class="text-center mt-3"></div>

<p class="text-center mt-3 text-light">
Already have an account?
<a href="login.php">Login</a>
</p>

</div>

<script>

$("#registerForm").submit(function(e){

e.preventDefault();

$.ajax({

url:"api/register_user.php",
method:"POST",
data:$(this).serialize(),

success:function(response){

if(response==="success"){

$("#registerMsg").html("<span class='text-success'>Account created!</span>");

setTimeout(function(){
window.location="login.php";
},1200);

}else{

$("#registerMsg").html("<span class='text-danger'>"+response+"</span>");

}

}

});

});

</script>

</body>
</html>