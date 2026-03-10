<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "travelit";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>