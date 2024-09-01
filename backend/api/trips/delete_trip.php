<?php
include '../db.php';
include '../headers.php';

// Decode JSON
$data = json_decode(file_get_contents('php://input'), true);

// Retrieve trip ID from POST request
$id = $data['id'] ?? null;

if ($id === null) {
    die(json_encode(["error" => "Trip ID is required"]));
}

try {
    // Retrieve cover image path
    $stmt = $pdo->prepare("SELECT cover_img FROM trips WHERE id = ?");
    $stmt->execute([$id]);
    $trip = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete cover image file if it exists
    if ($trip && $trip['cover_img']) {
        $imagePath = __DIR__ . '/../../uploads/' . $trip['cover_img'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Retrieve all image paths associated with the trip's days
    $stmt = $pdo->prepare("
        SELECT di.image_path 
        FROM day_images di
        JOIN days d ON di.day_id = d.id
        WHERE d.trip_id = ?
    ");
    $stmt->execute([$id]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the images and delete them from storage
    foreach ($images as $image) {
        $imagePath = __DIR__ . '/../../uploads/' . $image['image_path'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete trip
    $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["message" => "Trip and all associated images deleted successfully"]);
} catch (PDOException $e) {
    die(json_encode(["error" => "Could not delete trip: " . $e->getMessage()]));
}
?>