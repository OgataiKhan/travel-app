<?php
include '../db.php';
include '../headers.php';

// Decode JSON
$data = json_decode(file_get_contents('php://input'), true);

$day_id = $data['id'] ?? null;

try {
    $stmt = $pdo->prepare("DELETE FROM days WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["message" => "Day deleted successfully"]);
} catch (PDOException $e) {
    die("Error deleting day: " . $e->getMessage());
}
?>
