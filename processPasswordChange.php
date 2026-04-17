<?php
include 'config.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword === $confirmPassword) {
        // Verify the old password
        $query = "SELECT * FROM users WHERE password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $oldPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the password
            $updateQuery = "UPDATE users SET password = ? WHERE password = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ss", $newPassword, $oldPassword);
            if ($updateStmt->execute()) {
                echo "Password updated successfully.";
            } else {
                echo "Error updating password: " . $updateStmt->error;
            }
            $updateStmt->close();
        } else {
            echo "Incorrect old password.";
        }

        $stmt->close();
    } else {
        echo "New password and confirm password do not match.";
    }

    $conn->close();
}
?>
