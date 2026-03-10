<?php

require_once("../config/db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$hash = password_hash($password,PASSWORD_DEFAULT);

$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s",$email);
$check->execute();
$res = $check->get_result();

if($res->num_rows>0){

echo "Email already exists";
exit();

}

$stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
$stmt->bind_param("sss",$name,$email,$hash);

if($stmt->execute()){

echo "success";

}else{

echo "Registration failed";

}