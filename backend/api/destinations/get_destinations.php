<?php
include '../db.php';
include '../headers.php';

// Get the parameters from the URL
$day_id = $_GET['day_id'] ?? null;
$id = $_GET['id'] ?? null;

try {
    if ($id) {
        // If ID is provided, fetch single destination
        $stmt = $pdo->prepare("SELECT * FROM destinations WHERE id = ?");
        $stmt->execute([$id]);
        $destination = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($destination);
    } elseif ($day_id) {
        // If day_id is provided, fetch all destinations for that day
        $stmt = $pdo->prepare("SELECT * FROM destinations WHERE day_id = ?");
        $stmt->execute([$day_id]);
        $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($destinations);
    } else {
        // If no parameters are provided, return error message
        echo json_encode(["error" => "No valid parameters provided."]);
    }
} catch (PDOException $e) {
    die("Error retrieving destinations: " . $e->getMessage());
}
?>
