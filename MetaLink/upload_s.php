<?php
include 'config.php';
// Ensure the user is logged in and `username` cookie is set
if (!isset($_COOKIE['username'])) {
    die("User not logged in.");
}

$username = $_COOKIE['username'];
$targetDir = "status/";

if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
    $videoName = basename($_FILES['video']['name']);
    $targetFilePath = $targetDir . $videoName;

    // Rename file if it already exists
    $fileExtension = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $baseName = pathinfo($targetFilePath, PATHINFO_FILENAME);
    $i = 1;
    while (file_exists($targetFilePath)) {
        $videoName = $baseName . '_' . $i . '.' . $fileExtension;
        $targetFilePath = $targetDir . $videoName;
        $i++;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['video']['tmp_name'], $targetFilePath)) {
        // Insert video details into the database
        $seen = 0;
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO status (username, video_name, seen) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $videoName, $seen);
        
        if ($stmt->execute()) {
            echo "File uploaded and database updated.";
        } else {
            echo "Database error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "File upload error.";
    }
} else {
    echo "No file uploaded or upload error.";
}
?>
