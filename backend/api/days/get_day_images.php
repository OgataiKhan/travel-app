<?php
include '../db.php';
include '../headers.php';

// Get day_id from URL parameters
$day_id = $_GET['day_id'] ?? null;

if ($day_id) {
    try {
        // Fetch all images associated with the day, including the id
        $stmt = $pdo->prepare("SELECT id, image_path FROM day_images WHERE day_id = ?");
        $stmt->execute([$day_id]);
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($images);
    } catch (PDOException $e) {
        die(json_encode(["error" => "Error retrieving images: " . $e->getMessage()]));
    }
} else {
    // If no day_id is provided, return an error
    echo json_encode(["error" => "No valid day_id provided."]);
}
?>
