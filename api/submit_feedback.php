<?php
session_start();
require_once("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $message = trim($_POST['message'] ?? '');
    $rating = trim($_POST['rating'] ?? null);

    if ($message === '') {
        echo "Message cannot be empty.";
        exit;
    }

    // If user is logged in, get their user_id
    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : NULL;

    // Prepare and execute query safely
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, message, rating) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $message, $rating); // i=int, s=string, i=int

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
}
?>