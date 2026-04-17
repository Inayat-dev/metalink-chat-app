<?php

include 'config.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $usern = mysqli_real_escape_string($conn, $_POST['username']);
    $passwor = mysqli_real_escape_string($conn, $_POST['password']);

    if ($conn) {
        // Query to check if the user exists
        $query = "SELECT * FROM Users WHERE username='$usern' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify the password
            if ($user['password'] == $passwor) {
                setcookie("username", "".$user['username']."", time() + 3600 *24, "/");
                $_COOKIE['username'] = $user['username']; 
                $_COOKIE['image'] = $user['profile_image'];// Store username in session
                header("Location: home.php"); // Redirect to home page
                exit();
            } else {
                header("Location: index.html?error=invalid");
            }
        } else {
            header("Location: index.html?error=invalid");
        }
    } else {
        echo "Connection failed: " . mysqli_connect_error();
    }
}
?>
