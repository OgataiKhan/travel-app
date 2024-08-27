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
    // Step 1: Retrieve the image path
    $stmt = $pdo->prepare("SELECT cover_img FROM trips WHERE id = ?");
    $stmt->execute([$id]);
    $trip = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($trip && $trip['cover_img']) {
        $imagePath = __DIR__ . '/../../uploads/' . $trip['cover_img'];

        // Step 2: Delete the image file if it exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Step 3: Delete the trip
    $stmt = $pdo->prepare("DELETE FROM trips WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["message" => "Trip and associated image deleted successfully"]);
} catch (PDOException $e) {
    die(json_encode(["error" => "Could not delete trip: " . $e->getMessage()]));
}
?>
