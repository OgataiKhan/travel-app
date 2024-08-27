<?php
include '../db.php';
include '../headers.php';

$day_id = $_POST['day_id'];
$name = $_POST['name'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$description = $_POST['description'];

// TEMP
if (!is_numeric($latitude)) {
    $latitude = null;
}

if (!is_numeric($longitude)) {
    $longitude = null;
}
// TEMP

try {
    $stmt = $pdo->prepare("INSERT INTO destinations (day_id, name, latitude, longitude, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$day_id, $name, $latitude, $longitude, $description]);
    echo json_encode(["message" => "Destination added successfully"]);
} catch (PDOException $e) {
    die("Error adding destination: " . $e->getMessage());
}
?>
