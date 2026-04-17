<?php
include 'config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$get_info = mysqli_query($conn, "SELECT id, username, bio, profile_image FROM users WHERE username = '" . mysqli_real_escape_string($conn, $_COOKIE['username']) . "'");
$record = $get_info->fetch_assoc();
$userId = $record['id'];
$userN = $record['username'];
$userB = $record['bio'];
$currentImage = $record['profile_image'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $bio = $_POST['bio'];

    // Check current profile image
    $profileImagePath = $currentImage;

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        // Remove old image if it exists
        if ($currentImage && file_exists("profile/" . $currentImage)) {
            unlink("profile/" . $currentImage);
        }

        $profileImagePath = "profile/" . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $profileImagePath);
    }

    // Update user details
    $update_seen_uploader = mysqli_query($conn,"UPDATE seen SET username = '$username' WHERE username = '".$_COOKIE['username']."'");
    $update_seen_receiver = mysqli_query($conn,"UPDATE status SET username = '$username' WHERE username = '".$_COOKIE['username']."'");
    $update_request_sender = mysqli_query($conn,"UPDATE request SET sender = '$username' WHERE sender = '".$_COOKIE['username']."'");
    $update_request_receiver = mysqli_query($conn,"UPDATE request SET reciver = '$username' WHERE reciver = '".$_COOKIE['username']."'");
    $update_messages_sender = mysqli_query($conn,"UPDATE messages SET sender = '$username' WHERE sender = '".$_COOKIE['username']."'");
    $update_messages_receiver = mysqli_query($conn,"UPDATE messages SET reciver = '$username' WHERE reciver = '".$_COOKIE['username']."'");
    $update_freinds_other = mysqli_query($conn,"UPDATE friends SET myfriend = '$username' WHERE myfriend = '".$_COOKIE['username']."'");
    $update_freinds_me = mysqli_query($conn,"UPDATE friends SET name = '$username' WHERE name = '".$_COOKIE['username']."'");
    $query = "UPDATE users SET username = ?, bio = ?, profile_image = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $username, $bio, $profileImagePath, $userId);

    if ($stmt->execute()) {
        echo "User updated successfully";
        setcookie("username", "".$username."", time() + 3600 *24, "/");
        header('Location:profile.php');
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #111b21;
            color: white;
        }

        form {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #202c33;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #ddd;
        }

        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 4px;
            background-color: #333;
            color: #ddd;
        }

        span{
            margin-bottom:10px;
        }

        form textarea {
            height: 100px;
            resize: vertical;
        }

        form input[type="file"] {
            margin-top: 10px;
            color: #ddd;
        }

        form button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #25d366;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #1b9d50;
        }

        form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #25d366;
        }

        .image{
            width: 100%;
            height: 200px;
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .imageO {
            width: 150px;
            overflow-y: hidden;
            border-radius: 100px;
            box-shadow: 0 0px 10px 10px black;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: ani 1.5s ease-in-out infinite;
        }

        .image_img {
            height: 150px;
            width: 150px;
            border-radius: 100px;
        }

        /* Keyframe for heartbeat effect */
        @keyframes ani {
            0%, 100% {
                box-shadow: 0 0px 5px 5px #25d366;
            }
            30% {
                box-shadow: 0 0px 7.5px 7.5px #25d366;
            }
            60% {
                box-shadow: 0 0px 10px 10px #25d366;
            }
        }


    </style>
</head>
<body>
    <form action="edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>"> 

        <div class="image">
            <label for="image" class="imageO"><img src="profile/default.jpg" class="image_img" id="i" alt=""></label>
            <input type="file" style="display: none;" oninput="change_image(this)"  name="profile_image" id="image">
            
        </div>

        <label for="username">Username:</label>
        <span id="suggestion"></span>
        <input type="text" name="username" value="<?php echo htmlspecialchars($userN); ?>" oninput="check(this)" id="username" required><br><br>
        
        <label for="bio">Bio:</label>
        <textarea name="bio" id="bio" required><?php echo htmlspecialchars($userB); ?></textarea><br><br>


        <button type="submit">Update</button>
    </form>

    <script>
        const usern = '<?php echo $_COOKIE["username"];?>' 

        function change_image(input) {
            const file = input.files[0];
            const imageElement = document.getElementById("i");
            console.log(file);
            console.log(URL.createObjectURL(file));
            if (file) {
                // Create a URL for the selected image file
                const imageUrl = URL.createObjectURL(file);
                
                // Set the src of the image element to the new image URL
                imageElement.src = imageUrl;
            }
        }
        async function check(input){
            let username = input.value;
            let suggestion = document.getElementById('suggestion');
            const res = await fetch('check_username.php?username='+username);
            const data = await res.json()
            if(data.username == 'done' ){
                suggestion.innerHTML = "username <b>"+username+"</b> is available"
                suggestion.style.color = "green"
            }else if(username == ''){
                suggestion.innerHTML="";
                register = false
            }
            else if(data.username == 'sorry' && username != usern){
                suggestion.innerHTML = "username <b>"+username+"</b> is already exist"  
                suggestion.style.color = "red"  
                register = false     
            }else{
                suggestion.innerHTML = "username <b>"+username+"</b> is current username"  
                suggestion.style.color = "white"  
            }
        }
    </script>
</body>
</html>
