<?php
include '../db.php';
include '../headers.php';

$trip_id = $_POST['trip_id'];
$date = $_POST['date'];
$description = $_POST['description'];

try {
    $stmt = $pdo->prepare("INSERT INTO days (trip_id, date, description) VALUES (?, ?, ?)");
    $stmt->execute([$trip_id, $date, $description]);
    echo json_encode(["message" => "Day added successfully"]);
} catch (PDOException $e) {
    die("Error adding day: " . $e->getMessage());
}
?>
