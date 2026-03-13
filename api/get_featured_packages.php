<?php
require_once("../config/db.php");

$sql = "
SELECT 
p.id,
p.destination_id,
p.days,
p.transport,
p.price,
d.name AS destination
FROM packages p
JOIN destinations d ON p.destination_id = d.id
WHERE p.featured = 1
";

$result = $conn->query($sql);

$packages = [];

while($row = $result->fetch_assoc()){
    $packages[] = $row;
}

echo json_encode($packages);
?>