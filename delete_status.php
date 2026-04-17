<?php
include 'config.php';

$id = (int)$_POST['delete_status'];

// Retrieve the filename from the database
$file_query = mysqli_query($conn, "SELECT video_name FROM status WHERE id = $id");
$record = $file_query->fetch_assoc();

if ($record) {
    $filename = $record['video_name'];
    $filepath = "status/" . $filename;

    // Check if the file exists in the status folder and delete it
    if (file_exists($filepath)) {
        if (unlink($filepath)) {
            // File deleted successfully, now delete the database record
            $delete = mysqli_query($conn, "DELETE FROM status WHERE id = $id");

            if ($delete) {
                header('Location: status_upload.php');
                exit();
            } else {
                echo "Error deleting record from database. Please try again.";
            }
        } else {
            echo "Error deleting file. Please check file permissions.";
        }
    } else {
        echo "File not found in the status folder.";
    }
} else {
    echo "Record not found.";
}
?>
