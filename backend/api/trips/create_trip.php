<?php
include '../db.php';
include '../headers.php';

// Retrieve trip data from POST request
$title = $_POST['title'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

try {
    $query = "INSERT INTO trips (title, description, start_date, end_date) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $description, $start_date, $end_date]);
    echo json_encode(["message" => "Trip created successfully"]);
} catch (PDOException $e) {
    die("Could not create trip: " . $e->getMessage());
}
?>
