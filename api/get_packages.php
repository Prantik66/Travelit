<?php
include("../config/db.php");

$packages = [];

// If destination_id exists AND not empty
if (isset($_GET['destination_id']) && !empty($_GET['destination_id'])) {
    
    $destination_id = intval($_GET['destination_id']);
    $sql = "SELECT * FROM packages WHERE destination_id = $destination_id";

} else {

    // No filter → show ALL packages
    $sql = "SELECT * FROM packages";
}

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
}

echo json_encode($packages);
?>
