<?php
include '../db.php';
include '../headers.php';

// Handle file upload
$cover_img = null;  // Default to null if no image is uploaded
if (isset($_FILES['cover_img']) && $_FILES['cover_img']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../uploads/';
    $originalFileName = pathinfo($_FILES['cover_img']['name'], PATHINFO_FILENAME);
    $fileExtension = pathinfo($_FILES['cover_img']['name'], PATHINFO_EXTENSION);

    // Generate unique filename w/ current timestamp
    $uniqueFileName = $originalFileName . '_' . time() . '.' . $fileExtension;
    $targetFilePath = $uploadDir . $uniqueFileName;

    // Move file to the target directory
    if (move_uploaded_file($_FILES['cover_img']['tmp_name'], $targetFilePath)) {
        $cover_img = $uniqueFileName;
    } else {
        die(json_encode(["message" => "Image upload failed."]));
    }
}

// Retrieve trip data from POST request
$title = $_POST['title'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

try {
    $query = "INSERT INTO trips (title, description, start_date, end_date, cover_img) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $description, $start_date, $end_date, $cover_img]);

    // Get ID of new trip
    $newTripId = $pdo->lastInsertId();

    echo json_encode(["message" => "Trip created successfully", "id" => $newTripId]);
} catch (PDOException $e) {
    die("Could not create trip: " . $e->getMessage());
}
?>
