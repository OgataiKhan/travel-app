<?php
include '../db.php';

$day_id = $_GET['day_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM destinations WHERE day_id = ?");
    $stmt->execute([$day_id]);
    $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($destinations);
} catch (PDOException $e) {
    die("Error retrieving destinations: " . $e->getMessage());
}
?>
