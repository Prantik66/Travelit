<?php
session_start();
require_once("../config/db.php");
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit();
}

// Fetch all feedback with user info
$feedbacks = $conn->query("
    SELECT f.id, u.name AS user_name, f.message, f.rating
    FROM feedback f
    LEFT JOIN users u ON f.user_id = u.id
    ORDER BY f.id DESC
");

// Delete feedback
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM feedback WHERE id=$id");
    header("Location: feedback.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback - Travelit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <h2>User Feedback</h2>

    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Message</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $feedbacks->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_name'] ?? 'Guest' ?></td>
                <td><?= $row['message'] ?></td>
                <td><?= $row['rating'] ?? 'N/A' ?></td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-light mt-3">Back to Dashboard</a>
</div>
</body>
</html>