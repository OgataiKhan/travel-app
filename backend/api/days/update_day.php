<?php
include '../db.php';
include '../headers.php';

$id = $_POST['id'];
$description = $_POST['description'];

// Update day description
try {
    $stmt = $pdo->prepare("UPDATE days SET description = ? WHERE id = ?");
    $stmt->execute([$description, $id]);
    echo json_encode(["message" => "Day updated successfully"]);
} catch (PDOException $e) {
    die("Error updating day: " . $e->getMessage());
}

// Handle multiple image uploads
if (isset($_FILES['images'])) {
    $uploadDir = '../../uploads/';
    $uploadedImages = $_FILES['images'];
    $imageCount = count($uploadedImages['name']);
    $uploadedPaths = [];

    for ($i = 0; $i < $imageCount; $i++) {
        if ($uploadedImages['error'][$i] === UPLOAD_ERR_OK) {
            $originalFileName = pathinfo($uploadedImages['name'][$i], PATHINFO_FILENAME);
            $fileExtension = pathinfo($uploadedImages['name'][$i], PATHINFO_EXTENSION);

            // Generate unique filename w/ current timestamp and unique ID to handle simultaneous upload of images with the same name
            $uniqueFileName = $originalFileName . '_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $targetFilePath = $uploadDir . $uniqueFileName;

            // Move file to target directory
            if (move_uploaded_file($uploadedImages['tmp_name'][$i], $targetFilePath)) {
                $uploadedPaths[] = $uniqueFileName;
            } else {
                die(json_encode(["message" => "Failed to upload file: " . $uploadedImages['name'][$i]]));
            }
        } else {
            die(json_encode(["message" => "Error uploading file: " . $uploadedImages['name'][$i]]));
        }
    }

    // Insert uploaded image paths into day_images table
    try {
        $query = "INSERT INTO day_images (day_id, image_path) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);

        foreach ($uploadedPaths as $path) {
            $stmt->execute([$id, $path]);
        }

        echo json_encode(["message" => "Images uploaded successfully"]);
    } catch (PDOException $e) {
        die("Could not save images: " . $e->getMessage());
    }
}
?>
