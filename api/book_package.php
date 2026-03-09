<?php
require_once("../config/db.php");
session_start();

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Please login first."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$package_id = intval($_POST['package_id']);
$travel_date = $_POST['travel_date'];
$num_people = intval($_POST['num_people']);

if ($travel_date < date("Y-m-d")) {
    echo json_encode(["status" => "error", "message" => "Invalid travel date."]);
    exit();
}

$result = $conn->query("SELECT price FROM packages WHERE id = $package_id");
$package = $result->fetch_assoc();

if (!$package) {
    echo json_encode(["status" => "error", "message" => "Invalid package."]);
    exit();
}

$total_price = $package['price'] * $num_people;

$query = "INSERT INTO bookings 
          (user_id, package_id, travel_date, num_people, total_price, status)
          VALUES 
          ('$user_id', '$package_id', '$travel_date', '$num_people', '$total_price', 'pending')";

if ($conn->query($query)) {
    echo json_encode(["status" => "success", "message" => "Booking successful!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Booking failed."]);
}
?>
