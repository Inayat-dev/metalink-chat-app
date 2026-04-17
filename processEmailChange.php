<?php
include 'config.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldEmail = $_POST['oldEmail'];
    $password = $_POST['password'];
    $newEmail = $_POST['newEmail'];

    // Verify the old email and password
    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $oldEmail, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the email
        $updateQuery = "UPDATE users SET email = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ss", $newEmail, $oldEmail);
        if ($updateStmt->execute()) {
            echo "Email updated successfully.";
            header('Location:email.php?message=done');
        } else {
            echo "Error updating email: " . $updateStmt->error;
            header('Location:email.php?message=error');
        }
        $updateStmt->close();
    } else {
        echo "Incorrect old email or password.";
        header('Location:email.php?message=not');
    }

    $stmt->close();
    $conn->close();
}
?>
