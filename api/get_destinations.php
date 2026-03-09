<?php
include("../config/db.php");

$sql = "SELECT * FROM destinations";
$result = $conn->query($sql);

$destinations = [];

while ($row = $result->fetch_assoc()) {
    $destinations[] = $row;
}

echo json_encode($destinations);
?>
