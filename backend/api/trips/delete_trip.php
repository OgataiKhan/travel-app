<?php
include '../db.php';
include '../headers.php';

// Decode JSON
$data = json_decode(file_get_contents('php://input'), true);

// Retrieve trip ID from POST request
$id = $data['id'] ?? null;

try {
    $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["message" => "Trip deleted successfully"]);
} catch (PDOException $e) {
    die("Could not delete trip: " . $e->getMessage());
}
?>
