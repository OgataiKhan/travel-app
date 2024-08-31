<?php
include '../db.php';
include '../headers.php';

$id = $_POST['id'];
$name = $_POST['name'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$description = $_POST['description'];

if (!is_numeric($latitude)) {
    $latitude = null;
}

if (!is_numeric($longitude)) {
    $longitude = null;
}

try {
    $stmt = $pdo->prepare("UPDATE destinations SET name = ?, latitude = ?, longitude = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $latitude, $longitude, $description, $id]);
    echo json_encode(["message" => "Destination updated successfully"]);
} catch (PDOException $e) {
    die("Error updating destination: " . $e->getMessage());
}
?>
