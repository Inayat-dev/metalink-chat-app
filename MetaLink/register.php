<?php
include 'config.php';
$user = $_POST['username'];
$email = $_POST['email'];
$bio = $_POST['bio'];
$pass = $_POST['password'];

if (isset($_POST['submit'])) {
    if ($conn) {
        // Check if the username already exists
        $checkUser = mysqli_query($conn, "SELECT * FROM Users WHERE username = '$user'");

        if (mysqli_num_rows($checkUser) > 0) {
            // Username already exists, redirect to previous page with error
            header("Location: index.html?error=username_exists");
            exit();
        } else {
            // Username does not exist, proceed with insertion
            $insert = mysqli_query($conn, "INSERT INTO Users(username,bio, email, password) VALUES('$user','$bio', '$email', '$pass')");

            if ($insert) {
                setcookie("username", "".$user."", time() + 3600 *24, "/");
                header("Location: home.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Connection failed: " . mysqli_connect_error();
    }
}
?>
