<?php
include '../db.php';

// Retrieve trip data and ID from POST request
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

try {
    $query = "UPDATE trips SET title = ?, description = ?, start_date = ?, end_date = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $description, $start_date, $end_date, $id]);
    echo json_encode(["message" => "Trip updated successfully"]);
} catch (PDOException $e) {
    die("Could not update trip: " . $e->getMessage());
}
?>
