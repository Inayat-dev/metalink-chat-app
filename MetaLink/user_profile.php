<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #111b21;
            color: white;
        }
        
        .profile-container {
            padding: 20px;
            text-align: center;
        }

        .profile-header {
            position: relative;
        }

        .settings-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #25d366;
            cursor: pointer;
        }

        .profile-picture img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #25d366;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #202c33;
            padding: 10px 0;
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.3);
            border-top: 1px solid #333;
        }

        .bottom-nav .icon {
            color: #fff;
            font-size: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }

        /* Sidebar styling */
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #202c33;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            box-shadow: -2px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #25d366;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #333;
        }

        .sidebar .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            color: #25d366;
            cursor: pointer;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #202c33;
            padding: 10px 0;
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.3);
            border-top: 1px solid #333;
        }

        .total_un{
            background-color: #02db53;
            width: 17px;
            height: 17px;
            font-size: 12px;
            border-radius:50px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate3d(11px,9px,0px);
        }

        .hide{
            display: none;
        }

        .status span{
            font-weight: lighter;
        }

        /* Icon styling */
        .bottom-nav .icon {
            color: #fff;
            font-size: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        /* Icon hover effect */
        .bottom-nav .icon:hover {
            color: #25d366;
        }

        /* Label styling under each icon */
        .bottom-nav .icon-label {
            font-size: 0.8rem;
            margin-top: 3px;
            color: #ddd;
        }

        .active{
            color:#25d366;
        }

        .status{
            background-color: #25d366;
            width: 45px;
            height: 45px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            
        }

        .overview{
            display: flex;
            width: 100%;
            margin-top: 60px;
            align-items: center;
            justify-content: space-evenly;
            color: #02db53;
            font-size: 20px;
            font-family: monospace;
        }

        .overview_item{
            line-height: 7px;
        }

        .status_list {
            width: 100%;
            color: #02db53;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            margin: 40px 0 0px 0;
            padding: 20px 0 0 0;
            gap: 15px; /* Space between items for a cleaner layout */
        }

        .status_item {
            position: relative; /* For overlay effect */
            width: calc(50% - 10px); /* Adjust width to create a grid layout */
            background-color: #1c1c1e;
            height: 240px; /* Fixed height for a consistent look */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            overflow: hidden; /* Crop the video edges for a rounded look */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
        }

        
        .status_item:hover {
            transform: scale(1.05); /* Slight zoom effect on hover */
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.8);
        }

        .status_item::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
             /* To ensure gradient overlay stays above video */
            border-radius: 15px;
        }

        .video {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures video fills container neatly */
            z-index: 0;
        }

        /* Optional caption style for overlay text */
        .status_item .caption {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            font-size: 0.9rem;
            z-index: 2;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .status_item:hover .caption {
            opacity: 1; /* Show caption on hover */
        }

        .reels{
            position: fixed;
            top: 0;
            opacity: 1;
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: black;
            flex-direction: column;
        }

        .reel_item{
            width: 400px;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: black;
            opacity: 1;
            flex-direction: column;
        }

        .reel{
            width: 100%;
            background-color: black;
            opacity: 1;
        }

        
        .hide_reels{
            display: none;
        }

        @media (min-width: 768px) {
            .status_item{
                width: calc(33% - 10px);
            }
        }

        /* Desktop screens (1024px and up) */
        @media (min-width: 1024px) {
            .status_item{
                width: calc(20% - 10px);
            }
        }
        
    </style>
</head>
<body>
<div class="back-arrow" style="color: white;margin: 15px 0 0 15px ">
                &nbsp;&nbsp;<a href="chat.php?user=<?php echo $_GET['username']?>"><i class="fas fa-arrow-left" style="font-size: 130%;color:white;"></i></a>
            </div>
    <div class="profile-container">
        
        <div class="profile-header">
            <div class="profile-picture">
                <?php
                    include 'config.php';

                    function getUserProfileImage($username) {
                        global $conn;
                        $stmt = $conn->prepare("SELECT profile_image FROM Users WHERE username = ? LIMIT 1");
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $user = $result->fetch_assoc();
                            return $user['profile_image']; 
                        } else {
                            return null; 
                        }
                    }

                    $img = getUserProfileImage($_GET['username']);
                    echo $img ? "<img src='$img'>" : '<img src="profile/default.jpg">';
                ?>
            </div>
            <h2 class="username"><?php echo $_GET['username']; ?></h2>
            <p class="bio">
                <?php
                    function getBio($username) {
                        global $conn;
                        $stmt = $conn->prepare("SELECT bio FROM Users WHERE username = ? LIMIT 1");
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $user = $result->fetch_assoc();
                            return $user['bio']; 
                        } else {
                            return "Hey! I'm here on Metalink to chat, connect, and keep in touch. Let’s link up!";
                        }
                    }
                    echo getBio($_GET['username']);
                ?>
            </p>
        </div>
        <div class="overview">
            <div class="overview_item">
                <h3>
                    <?php
                        include 'config.php';
                        $friends = mysqli_query($conn,"SELECT * FROM friends WHERE name = '".$_GET['username']."'");
                        print_r($friends->num_rows);
                    ?>
                </h3>
                <span>Friends</span>
            </div>
            <div class="overview_item">
                <h3>
                
                <?php
                        $status = mysqli_query($conn,"SELECT time FROM status WHERE username = '".$_GET['username']."'");
                        print_r($status->num_rows);
                    ?>

                </h3>
                <span>status</span>
            </div>
            
        </div>
        
    </div>

    <div class="status_list">
            
            <?php
                include 'config.php';
                $status = mysqli_query($conn,"SELECT * FROM status WHERE username ='".$_GET['username']."'");
                
                if($status->num_rows<=0){
                    echo "empty status ";
                }
                while($row = $status->fetch_assoc()){
                    echo '
                        <div class="status_item" onclick="show_status(\'status/'.$row['video_name'].'\')">
                            <video src="status/'.$row['video_name'].'" class="video"></video>     
                        </div>
                    ';
                }
                // if($status['num_rows']>0){
                //     echo "NO status uploaded";
                // }
                
            ?>
            
        </div>
        <br><br><br><br><br><br><br><br><br><br>
    <!-- Sidebar for Edit Profile, Settings, and Logout -->
    
    <div class="reels hide_reels" id="status_reel">
        
        </div>
    <script>
       let count = 1;

        function show_status(src){
            //status_reel
            let block = `<div style="width: 90%;padding:10px 0 0 10px; ">
            <i class="fas fa-arrow-left" onclick="back()" style="font-size: 130%;"></i>
        </div>
            

            <div class="reel_item">
                <video src="${src}" class="reel"></video>
                
            </div>
        `;
                let reel = document.getElementById('status_reel');
                
            if(count == 1){
                reel.innerHTML = block;
                reel.classList.remove('hide_reels');
            }else{
                reel.innerHTML = "";
                reel.classList.add('hide_reels');
            }
        }

        function back(){
            let reel = document.getElementById('status_reel');
            reel.classList.add('hide_reels');
            reel.innerHTML = "";
        }

    </script>
</body>
</html>
