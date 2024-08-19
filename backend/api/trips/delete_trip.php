<?php
include '../db.php';

// Retrieve trip ID from POST request
$id = $_POST['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["message" => "Trip deleted successfully"]);
} catch (PDOException $e) {
    die("Could not delete trip: " . $e->getMessage());
}
?>
