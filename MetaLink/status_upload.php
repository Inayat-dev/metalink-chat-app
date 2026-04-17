<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

        .chat-item video {
            width: 60px;
            height: 60px;
            margin-right: 10px;
            border-radius: 100px;
            border: 3px solid #25d366;
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

        .un_read{
            background-color: #02db53;
            width: 17px;
            height: 17px;
            font-size: 12px;
            border-radius:50px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate3d(-20px,-10px,0px);
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

        .new{
            color:white;
        }

        .indi{
            color: #A7A7A7;
        }

                /* Initial style for the .new element */
        .new {
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .hide{
            display: none;
        }

        /* Animation class for fading in the new message */
        .fade-in {
            animation: fadeInEffect 0.5s ease;
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

        video{
            box-shadow: 0  1px 5px #02db53;
        }

        .status span{
            font-weight: 900;
        }

        .upload{
            color: white;
            background: #02db53;
            border: none;
            padding: 5px 17px;
            border-radius: 7px;
        }

        .delete{
            background-color: red;
            border: none;
            color: #fff;
            border-radius: 12px;
            padding: 5px 12px;
            font-size: 14px;
            justify-content: space-between;
        }

        .status_view_parent{
            
            width: 100%;
            position: fixed;
            height: 100vh;
            top: 0;
            backdrop-filter: blur(8px);
            margin: 0;
            padding: 0;
        }

        .status_view_parent i{
            margin: 20px;
        }

        .status_view{
            width:99%;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            
        }

        .status_view video{
            box-shadow: 0 0 14px 3px #000;
            border-radius: 12px;
            width: 90%;
            overflow: hidden;
        }

        .back{
            right: 100px;
        }

        /* Keyframes for fade-in effect */
        @keyframes fadeInEffect {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

    </style>
</head>
<body>
        <h2 style="color: white;display:flex;justify-content:space-between;">
            <u>Resent Updates </u>
            <button class="upload" onclick="window.location.href='upload_status.php'">Upload New</button>
        </h2>
    <div class="status_window">

        <?php
            include 'config.php';
            $username = $_COOKIE['username'];
            $data = mysqli_query($conn,"SELECT * FROM status WHERE username='$username'");
            while($row = $data->fetch_assoc()){
                echo '<div class="chat-item" >';
                    echo '<video src="status/'.$row['video_name'].'"  autoplay loop onclick="view_status(\''.$row['video_name'].'\')" ></video>';
                    echo "<div class='chat-info' onclick='window.location.href=\"comments.php?status_id=".$row['id']."\"'>'";
                        echo '<h5 id="username"><i class="fa-solid fa-eye"></i> : '.$row['seen'].'</h5>';
                        echo '<div>';
                        echo '&nbsp;</div><div>&nbsp;</div>';
                    echo '</div>';
                    echo '<div class="chat-time">';
                        echo '<form action="delete_status.php" method="post">';    
                            echo '<button class="delete" type="submit" name="delete_status" value='.$row['id'].'">Delete</button>';
                        echo'</form>';
                    echo '</div>';
                echo '</div>';
            }
        ?>

        
    </div>
    
    <div class="status_view_parent hide" id="status">
            
                
            <!-- <video src="status/demo.mp4" class="status_view ">
            </video> -->
    </div>

    <br><br><br><br>
    <div class="bottom-nav">
        <div class="icon"  onclick="window.location.href='home.php'">
        <span class="online total_un hide" style="height: 17px;width:17px;color:white;font-size:12px;border-radius:50px;" id="total_un">
            <?php
                include 'config.php';
                    $all_un=mysqli_query($conn,"SELECT un_read FROM friends WHERE name='".$_COOKIE['username']."'");
                    $total_unread=0;
                    while($row=$all_un->fetch_assoc()){
                        $total_unread+=$row['un_read'];
                    }
                    echo $total_unread;
                ?>
            </span>
            <i class="fas fa-comments"></i>
            <span class="icon-label" >Chat</span>
        </div>
        <div class="icon" onclick="window.location.href='Users.php'">
            <i class="fas fa-users"></i>
            <span class="icon-label">Users</span>
        </div>
        <div class="icon status" onclick="window.location.href='#'">
            <span style="font-size: 50px;">
                    +
            </span>
        </div>
        <div class="icon" onclick="window.location.href='requests.php'">
            <i class="fas fa-envelope"></i>
            <span class="icon-label">Request</span>
        </div>
        <div class="icon" onclick="window.location.href='profile.php'">
            <i class="fas fa-user-circle"></i>
            <span class="icon-label">Profile</span>
        </div>
    </div>

    <script>
        function view_status(src){
            
            let block=`
            <i class="fas fa-arrow-left " onclick="back()" style="font-size: 130%;color:white;bottom:100px"></i>
            <div  class="status_view ">
                <video src="status/${src}" autoplay loop>
                </video>
            </div>`;
            let video=document.getElementById('status');
            video.innerHTML=block;
            video.classList.remove('hide');
        }

        function back(){
            let video=document.getElementById('status');
            video.innerHTML="";
            video.classList.add('hide');
        }
    </script>
    </body>
</html>