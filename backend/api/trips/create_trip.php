<?php
include '../db.php';
include '../headers.php';

// Decode JSON
$data = json_decode(file_get_contents('php://input'), true);

// Retrieve trip data from decoded array
$title = $data['title'];
$description = $data['description'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];

try {
    $query = "INSERT INTO trips (title, description, start_date, end_date) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $description, $start_date, $end_date]);

    // Get the ID of the new trip
    $newTripId = $pdo->lastInsertId();

    echo json_encode(["message" => "Trip created successfully", "id" => $newTripId]);
} catch (PDOException $e) {
    die("Could not create trip: " . $e->getMessage());
}
?>
