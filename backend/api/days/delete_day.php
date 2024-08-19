<?php
include '../db.php';

$id = $_POST['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM days WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["message" => "Day deleted successfully"]);
} catch (PDOException $e) {
    die("Error deleting day: " . $e->getMessage());
}
?>
