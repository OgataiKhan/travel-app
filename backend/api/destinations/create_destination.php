<?php
include '../db.php';
include '../headers.php';

$day_id = $_POST['day_id'];
$name = $_POST['name'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$description = $_POST['description'];

try {
    $stmt = $pdo->prepare("INSERT INTO destinations (day_id, name, latitude, longitude, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$day_id, $name, $latitude, $longitude, $description]);
    echo json_encode(["message" => "Destination added successfully"]);
} catch (PDOException $e) {
    die("Error adding destination: " . $e->getMessage());
}
?>
