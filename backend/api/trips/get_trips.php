<?php
include '../db.php';

// Check if a trip ID was provided
$id = $_GET['id'] ?? null;

try {
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM trips WHERE id = ?");
        $stmt->execute([$id]);
    } else {
        $stmt = $pdo->query("SELECT * FROM trips");
    }
    $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($trips);
} catch (PDOException $e) {
    die("Could not retrieve trips: " . $e->getMessage());
}
?>
