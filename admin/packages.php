<?php
session_start();
require_once("../config/db.php");
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit();
}

// Fetch destinations for the dropdown
$destinations = $conn->query("SELECT * FROM destinations ORDER BY name ASC");

// Handle new package
if(isset($_POST['add'])){
    $destination_id = $_POST['destination_id'];
    $days = $_POST['days'];
    $transport = $_POST['transport'];
    $price = $_POST['price'];
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    if($featured == 1){
    $stmt = $conn->prepare("UPDATE packages SET featured=0 WHERE destination_id=?");
    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    }
    $stmt = $conn->prepare("INSERT INTO packages (destination_id, days, transport, price, featured) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $destination_id, $days, $transport, $price, $featured);
    $stmt->execute();
    header("Location: packages.php");
    exit();
}

// Delete package
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM packages WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: packages.php");
    exit();
}

// Fetch packages with destination names
$packages = $conn->query("
SELECT p.id, p.days, p.transport, p.price, p.featured,
d.name AS destination_name
FROM packages p
JOIN destinations d ON p.destination_id = d.id
ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Packages - Travelit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <h2>Travel Packages</h2>
    
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="destination_id" class="form-control" required>
                <option value="">Select Destination</option>
                <?php while($d = $destinations->fetch_assoc()): ?>
                    <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="days" class="form-control" placeholder="Days (e.g., 5 Days)" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="transport" class="form-control" placeholder="Transport (e.g., Flight + Cab)" required>
        </div>
        <div class="col-md-2">
            <input type="text" name="price" class="form-control" placeholder="Price" required>
        </div>
        <div class="col-md-1">
        <label class="form-check-label">
            <input type="checkbox" name="featured" value="1"> Featured
        </label>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success w-100" name="add">Add Package</button>
        </div>
    </form>
    
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Destination</th>
                <th>Days</th>
                <th>Transport</th>
                <th>Price</th>
                <th>Featured</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $packages->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['destination_name'] ?></td>
                <td><?= $row['days'] ?></td>
                <td><?= $row['transport'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['featured'] ? 'Featured' : '-' ?></td>
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