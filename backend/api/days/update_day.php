<?php
include '../db.php';
include '../headers.php';

$id = $_POST['id'];
$date = $_POST['date'];
$description = $_POST['description'];

try {
    $stmt = $pdo->prepare("UPDATE days SET date = ?, description = ? WHERE id = ?");
    $stmt->execute([$date, $description, $id]);
    echo json_encode(["message" => "Day updated successfully"]);
} catch (PDOException $e) {
    die("Error updating day: " . $e->getMessage());
}
?>
