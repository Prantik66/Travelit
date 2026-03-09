<?php
$conn = new mysqli("localhost", "root", "abcd1234", "travelit.sql");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
