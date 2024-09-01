<?php
include '../db.php';
include '../headers.php';

// Decode JSON input
$data = json_decode(file_get_contents('php://input'), true);

$image_id = $data['image_id'] ?? null;

if (!$image_id) {
    echo json_encode(['error' => 'Image ID is required.']);
    exit;
}

try {
    // Fetch image path from database
    $stmt = $pdo->prepare("SELECT image_path FROM day_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $image = $stmt->fetch();

    if (!$image) {
        echo json_encode(['error' => 'Image not found.']);
        exit;
    }

    // Delete image file from server storage
    $image_path = '../../uploads/' . $image['image_path'];
    if (file_exists($image_path)) {
        unlink($image_path); // Delete the image file from storage
    }

    // Delete image record from database
    $stmt = $pdo->prepare("DELETE FROM day_images WHERE id = ?");
    $stmt->execute([$image_id]);

    echo json_encode(['message' => 'Image deleted successfully.']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error deleting image: ' . $e->getMessage()]);
}
?>
