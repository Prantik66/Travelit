<?php
include("../config/db.php");

header("Content-Type: application/json");

$packages = [];

// Check if destination filter exists
if(isset($_GET['destination_id']) && !empty($_GET['destination_id'])){

    $destination_id = intval($_GET['destination_id']);

    $stmt = $conn->prepare("
        SELECT p.*, d.name AS destination
        FROM packages p
        JOIN destinations d ON p.destination_id = d.id
        WHERE p.destination_id = ?
    ");

    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();

} else {

    $sql = "
        SELECT p.*, d.name AS destination
        FROM packages p
        JOIN destinations d ON p.destination_id = d.id
    ";

    $result = $conn->query($sql);
}

// Fetch packages
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $packages[] = $row;
    }
}

// Return JSON
echo json_encode($packages);
?>