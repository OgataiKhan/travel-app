<?php
include '../db.php';
include '../headers.php';

$id = $_POST['id'];
$description = $_POST['description']; // Only handle the description

try {
    $stmt = $pdo->prepare("UPDATE days SET description = ? WHERE id = ?");
    $stmt->execute([$description, $id]);
    echo json_encode(["message" => "Day updated successfully"]);
} catch (PDOException $e) {
    die("Error updating day: " . $e->getMessage());
}
?>