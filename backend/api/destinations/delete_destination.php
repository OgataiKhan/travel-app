<?php
include '../db.php';
include '../headers.php';

$id = $_POST['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM destinations WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["message" => "Destination deleted successfully"]);
} catch (PDOException $e) {
    die("Error deleting destination: " . $e->getMessage());
}
?>
