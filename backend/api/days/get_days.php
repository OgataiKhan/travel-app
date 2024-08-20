<?php
include '../db.php';
include '../headers.php';

$trip_id = $_GET['trip_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM days WHERE trip_id = ?");
    $stmt->execute([$trip_id]);
    $days = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($days);
} catch (PDOException $e) {
    die("Error retrieving days: " . $e->getMessage());
}
?>
