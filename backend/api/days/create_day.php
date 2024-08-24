<?php
include '../db.php';
include '../headers.php';

// Decode JSON
$data = json_decode(file_get_contents('php://input'), true);

// Retrieve day data from decoded array
$trip_id = $data['trip_id'];
$date = $data['date'];
$description = $data['description'];

try {
    $stmt = $pdo->prepare("INSERT INTO days (trip_id, date, description) VALUES (?, ?, ?)");
    $stmt->execute([$trip_id, $date, $description]);
    echo json_encode(["message" => "Day added successfully"]);
} catch (PDOException $e) {
    die("Error adding day: " . $e->getMessage());
}
?>
