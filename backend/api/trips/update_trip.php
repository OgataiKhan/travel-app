<?php
include '../db.php';
include '../headers.php';

// Retrieve trip data and ID from POST request
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];

// Check if a new image is uploaded
$cover_img = null;
$oldImage = null;

if (isset($_FILES['cover_img']) && $_FILES['cover_img']['error'] === UPLOAD_ERR_OK) {
    // Retrieve current cover image from database
    $stmt = $pdo->prepare("SELECT cover_img FROM trips WHERE id = ?");
    $stmt->execute([$id]);
    $oldImage = $stmt->fetchColumn();

    $uploadDir = '../../uploads/';
    $fileName = basename($_FILES['cover_img']['name']);
    $targetFilePath = $uploadDir . $fileName;

    // Move new file to target directory
    if (move_uploaded_file($_FILES['cover_img']['tmp_name'], $targetFilePath)) {
        $cover_img = $fileName;  // Save new filename

        // Delete old image if new one is uploaded
        if ($oldImage && file_exists($uploadDir . $oldImage)) {
            unlink($uploadDir . $oldImage);
        }
    } else {
        die(json_encode(["message" => "Image upload failed."]));
    }
}

try {
    // Update trip data, including cover image if new one is uploaded
    if ($cover_img) {
        $query = "UPDATE trips SET title = ?, description = ?, cover_img = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $description, $cover_img, $id]);
    } else {
        $query = "UPDATE trips SET title = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $description, $id]);
    }

    echo json_encode(["message" => "Trip updated successfully"]);
} catch (PDOException $e) {
    die("Could not update trip: " . $e->getMessage());
}
?>
