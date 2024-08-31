<?php
include '../db.php';
include '../headers.php';

// Get the parameters from URL
$trip_id = $_GET['trip_id'] ?? null;
$day_id = $_GET['day_id'] ?? null;

try {
    if ($day_id) {
        // If day_id is provided fetch single day
        $stmt = $pdo->prepare("SELECT * FROM days WHERE id = ?");
        $stmt->execute([$day_id]);
        $day = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($day);
    } elseif ($trip_id) {
        // If trip_id is provided fetch all days for that trip
        $stmt = $pdo->prepare("SELECT * FROM days WHERE trip_id = ?");
        $stmt->execute([$trip_id]);
        $days = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($days);
    } else {
        // If no parameters are provided return an error message
        echo json_encode(["error" => "No valid parameters provided."]);
    }
} catch (PDOException $e) {
    die("Error retrieving days: " . $e->getMessage());
}
?>
