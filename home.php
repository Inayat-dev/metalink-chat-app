<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        .status span{
            font-weight: 900;
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

        .status-list{
            display:flex;
            overflow: auto;
            gap: 15px;
            height: 120px;
            border-bottom: 2px solid #202c33;
        }

        .status-list::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .status_item{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #02db53;
            padding: 0 -30px;
        }

        .status_item span{
            font-size:small;
            font-weight: 500;
            width: 80px;
            text-align: center;
        }

        .status_icon{
            height: 70px;
            width: 70px;
            border-radius: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: conic-gradient(#25D366, #128C7E, #25D366, #128C7E);
        }

        .status_icon2{
            height: 66px;
            width: 66px;
            border-radius: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #111b21;
            overflow: hidden;
        }

        .status_icon2 video{
            height: 75px;
            width: 75px;
            border-radius: 120px;
        }

        html{
            margin-left: 0;
        }

        .status_view_parent{
            
            width: 100%;
            position: fixed;
            height: 100vh;
            top: 0;
            backdrop-filter: blur(20px);
            margin: 0;
            padding: 0;
            
        }

        .status_view_parent i{
            margin: 20px 0 0 20px;
            
        }

        .status_view{
            width:500px;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            
        }

        .status_view video{
            box-shadow: 0 0 14px 3px #000;
            border-radius: 12px;
            width: 100%;
            overflow: hidden;
            top: 0;
        }

        .back{
            right: 100px;
            cursor: pointer;
        }

        .dicription_button{
            background-color: transparent;
            border: none;
            width: 96%;
            margin-top: -35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            
        }

        .description_upload{
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 95%;
            margin-top: 40px;
            backdrop-filter: blur(12px);
        }

        .input_description{
            border: none;
            width: 85%;
            height: 30px;
            background-color: #222c32;
            color: white;
            border-radius: 7px;
            
        }

        .des_button{
            border-radius: 7.06px;
            border: none;
            width: 10%;
            height:32px;
            color: white;
            background-color: #007bff;
            display: flex;
        }

        .description_list{
            width: 100%;
            background-color: #222c32;
            height: 45vh;
            color: white;
            overflow: auto;
            padding-top: 2px;
            margin-top: 10px;
        }

        .description_list::-webkit-scrollbar{
            display: none;
        }

        .discription_item{
            padding: 5px 10px;
            margin-bottom: 2px;
            background-color: #111b21;
            width: 100%;
        }

        .username_d{
            color: #02db53;
            font-weight: bolder;

        }

        .text_d{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .up{
            margin-top: -80%;
            transition: margin-top 1s;
        }

        .down{
            margin-top: 0%;
            transition: margin-top 1s;
        }

        .rotate {
            transition: transform 0.3s ease; 
        }

        .rotate_normal {
            transform: rotate(180deg); /* Rotate the icon 90 degrees */
            transition: transform 0.3s ease; /* Smooth transition for the rotation */
        }

        .plus{
            color: #02db53;
            transform: translate3d(30px,-40px,0px);
        }


        @media (min-width: 768px) {
            .up {
                margin-top: -45%; /* Adjust for tablet view */
            }
            .down {
                margin-top: 0%; /* Adjust for tablet view */
            }
        }

        /* Desktop screens (1024px and up) */
        @media (min-width: 1024px) {
            .up {
                margin-top: -37%; /* Adjust for desktop view */
            }
            .down {
                margin-top: 0%; /* Adjust for desktop view */
            }
        }

        

        
    </style>
</head>
<body>
    <div class="search-bar">
        <input type="text" id="searchBar" oninput="searchChat()" placeholder="Search your chat">
    </div>

        <h2 style="color: white;">Recent Update</h2>
        <div class="status-list">
            <div class="status_item" style="margin-right: 20px;" onclick="window.location.href='status_upload.php'">
                <div class="status_icon">
                    <div class="status_icon2">
                        <?php
                            include 'config.php';
                            $user = mysqli_query($conn,"SELECT profile_image FROM users WHERE username = '".$_COOKIE['username']."'");
                            $record = $user->fetch_assoc();

                            if ($record['profile_image'] != "") {
                                echo "<img src='" . $record['profile_image'] . "' style='width:100%;'>";
                            } else {
                                echo '<img src="profile/default.jpg" style="width:100%;">';
                            }
                        ?>
                        
                    </div>
                </div>
                <span>mystatus</span>
                
            </div>
            
            
            <?php
                include 'config.php';
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $currentUsername = mysqli_real_escape_string($conn, $_COOKIE['username']);

                $sql = "
                    SELECT s.* 
                    FROM status s
                    JOIN friends f ON f.myfriend = s.username
                    WHERE f.name = '$currentUsername'
                ";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($status = mysqli_fetch_assoc($result)) {
                        echo"<div class='status_item' onclick='view_status(\"".$status['video_name']."\",\"".$status['id']."\")'>";
                            echo'<div class="status_icon">';
                                echo'<div class="status_icon2">';
                                    echo'<video src="status/'.$status['video_name'].'" ></video>';
                                echo'</div>';
                            echo '</div>';
                            
                            echo '<span class="user_n">'.$status['username'].'</span>';
                        echo '</div>';
                    }
                } else {
                    
                }
                mysqli_close($conn);
                ?>

        </div>


        <div class="status_view_parent hide" id="status">
        <!-- <i class="fas fa-arrow-left " onclick="back()" style="font-size: 130%;color:white;bottom:100px"></i>
            <div  class="status_view " id="view">
                <video src="status/demo.mp4" autoplay loop>
                </video>
            </div>
            <button class="dicription_button" onclick="up()"><i class="fas fa-arrow-up " style="color: white;font-size:210%;"></i></button>
            <div class="description_upload">
                <input type="text" placeholder="Write Description" class="input_description">
                <butto class=" des_button"><i class="fas fa-arrow-right " style="color: white;font-size:100%;margin:auto;"></i></button>
            </div>
            <div class="description_list " >
                    <div class="discription_item">
                        <span class="username_d">inayat :</span>
                        <span class="text_d">good video</span>
                    </div>
                    
                </div> -->
                <!-- <video src="status/demo.mp4" class="status_view ">
                </video> -->
        </div>



    <div class="chat-list">
        <?php
            include 'config.php';

            $currentUser = $_COOKIE['username']; // The current user from the cookie
            $insert_window = mysqli_query($conn,"UPDATE users SET user_window='home' where username='".$_COOKIE['username']."'");
            // SQL query to get all users who are friends with the current user
            $sql = "SELECT u.* 
                    FROM Users u
                    INNER JOIN friends f ON u.username = f.name 
                    WHERE f.myfriend = ?";

            // Prepare the statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $currentUser);
            $stmt->execute();
            $result = $stmt->get_result();

            $displayedUsers = []; // Array to keep track of displayed usernames

            if ($result->num_rows > 0) {
                // Fetch and display each row
                while ($user = $result->fetch_assoc()) {
                    if (!in_array($user['username'], $displayedUsers)) {
                        // Add the username to the array to mark it as displayed
                        $displayedUsers[] = $user['username'];
                        echo "<div class='chat-item' onclick='openChet(\"" . $user['username'] . "\")'>";
                            if ($user['profile_image'] != "") {
                                echo "<img src='" . $user['profile_image'] . "' >";
                            } else {
                                echo '<img src="profile/default.jpg" >';
                            }
                            $un_read=mysqli_query($conn,"SELECT un_read FROM friends WHERE name = '".$_COOKIE['username']."' AND myfriend='".$user['username']."'");
                            $row=$un_read->fetch_assoc();
                            $un_read=$row['un_read'];
                            if($un_read>0)
                            echo "<p class='un_read' id='".$user['username']."un'>$un_read</p>";
                            else{
                                echo "<p class='un_read hide' id='".$user['username']."un'>$un_read</p>"; 
                            }
                            echo "<div class='chat-info'>";
                                echo "<h5 id='username'>" . $user['username'] . "</h5>";
                                
                                
                                    if($user['bio']!=""){
                                        echo "<p class='new'>Bio : ".$user['bio']."</p>";
                                    }else{
                                        echo `<p class="new">Bio : Hey! I'm here on Metalink to chat, connect, and keep in touch. Let’s link up!</p>`;
                                    }
                                
                            
                            echo "</div>";
                            echo "<div class='chat-time'>";
                                if ($user['status'] == 'online') {
                                    echo "<p class='online' id='".$user['username']."'></p>";
                                } else {
                                    echo "<p class='offline' id='".$user['username']."'></p>";
                                }
                                
                            echo "</div>";
                        echo "</div>";
                    }
                }
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
            ?>
    
    
    </div>
    <br><br><br><br>
    <div class="bottom-nav">
        <div class="icon" style="color:#25d366;" onclick="window.location.href='home.php'">
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
            <span class="icon-label" style="color:#25d366;">Chat</span>
        </div>
        <div class="icon" onclick="window.location.href='Users.php'">
            <i class="fas fa-users"></i>
            <span class="icon-label">Users</span>
        </div>
        <div class="icon status" onclick="window.location.href='status_upload.php'">
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
        const username = document.cookie.replace(/(?:(?:^|.*;\s*)username\s*\=\s*([^;]*).*$)|^.*$/, "$1");
        const socket = new WebSocket(`ws://localhost:8000?username=${username}`);
        let current=1;

        let total_unread="<?php echo $total_unread;?>";

            if(total_unread>0){
                document.getElementById('total_un').classList.remove('hide')
            }

            function up(rotate){
                let view = document.getElementById('view');
                rotate = document.getElementById('rotate');
                if(current==2){
                    view.classList.remove('up');
                    view.classList.add('down');
                    console.log(current)
                    current=1
                    rotate.style.transform= 'rotate(360deg)';
                }else{
                    view.classList.remove('down');
                    view.classList.add('up');
                    console.log(current)
                    current=2
                    rotate.style.transform= 'rotate(180deg)';
                }
               
            }

            function searchChat() {
                const searchValue = document.getElementById("searchBar").value.toLowerCase();
                const chatItems = document.querySelectorAll(".chat-item");
                
                // Array to hold exact matches and similar matches
                let exactMatches = [];
                let similarMatches = [];

                chatItems.forEach(item => {
                    const usernameElement = item.querySelector("h5#username");
                    const username = usernameElement ? usernameElement.innerText.toLowerCase() : "";

                    // Clear the previous display state
                    item.style.display = "none";

                    if (username === searchValue) {
                        // Exact match
                        exactMatches.push(item);
                    } else if (username.includes(searchValue)) {
                        // Similar match
                        similarMatches.push(item);
                    }
                });

                // Display exact matches first, followed by similar matches
                exactMatches.concat(similarMatches).forEach(item => {
                    item.style.display = "flex";  // Show matching items
                    document.querySelector(".chat-list").appendChild(item);  // Reorder in chat list
                });
            }

            async function view_status(src, id) {
                await seen(id);

                // Fetch descriptions from PHP using the status_id
                fetch(`get_description.php?status_id=${id}`)
                    .then(response => response.json())
                    .then(descriptions => {
                        // Generate HTML for each description item
                        let descriptionItems = descriptions.map(desc => `
                            <div class="discription_item">
                                <span class="username_d">${desc.username} :</span>
                                <span class="text_d">${desc.text}</span>
                            </div>
                        `).join('');

                        // Construct the main HTML block with video and description list
                        let block = `
                            <i class="fas fa-arrow-left" onclick="back(this)"  style="font-size: 130%; color: white; bottom: 100px"></i>
                            <div class="status_view" id="view">
                                <video src="status/${src}" autoplay loop></video>
                            </div>
                            <button class="dicription_button" onclick="up(this)" >
                                <i class="fas fa-arrow-up rotate" id="rotate" style="color: white; font-size: 210%;"></i>
                            </button>
                            <div class="description_upload">
                                <input type="text" placeholder="Write comment" id='desc' class="input_description">
                                <button class="des_button" onclick="description_upload(${id},'${src}')">
                                    <i class="fas fa-arrow-right" style="color: white; font-size: 100%; margin: auto;"></i>
                                </button>
                            </div>
                            <div class="description_list" id="descriptions">
                                ${descriptionItems}
                            </div>
                        `;

                        // Display the constructed HTML block in the video container
                        let videoContainer = document.getElementById('status');
                        videoContainer.innerHTML = block;
                        videoContainer.classList.remove('hide');
                    })
                    .catch(error => console.error('Error fetching descriptions:', error));
            }

        async function seen(id){
            let data = await fetch('seen.php?id='+id+'&username='+username+'');
        }

        async function description_upload(id,src) {
            let desc = document.getElementById('desc').value;
            let response = await fetch(`description.php?id=${id}&username=${username}&description=${encodeURIComponent(desc)}`);
            let res = await response.json();
            console.log(res);
            let box = document.getElementById('descriptions');
            box.innerHTML+=`
                            <div class="discription_item">
                                <span class="username_d">${username} :</span>
                                <span class="text_d">${desc}</span>
                            </div>
            `
        }


        function back(rotate){
            let video=document.getElementById('status');
            video.innerHTML="";
            video.classList.add('hide');
            
        }
        
        socket.onopen = () => {
            console.log("Connected to WebSocket server");
        };
        let number = 10;

        socket.onmessage = (event) => {
            let data =JSON.parse(event.data);
            if(data.sender==undefined && data.status==undefined){
                change(data.replace,data.number);
                console.log("update unread",data);
                if(data.total>0){
                    let total = document.getElementById('total_un');
                    total.classList.remove('hide');
                    total.innerHTML=data.total;
                }
            }
            else if(data.sender==undefined && data.status!=undefined && username!=data.who){
                console.log(data)
                if(data.status=='online'){
                    let status=document.getElementById(''+data.who+'');
                    status.classList.remove('offline');
                    status.classList.add('online');
                }else if(data.status=='offline'){
                    let status=document.getElementById(''+data.who+'');
                    status.classList.remove('online');
                    status.classList.add('offline');
                }else{

                }
            }
            else if(data.sender!=undefined){
                newMessage(data.sender,"<span class='indi'>New Message : </span>"+data.message);
                //new
            }
            
            
        };

        socket.onclose = () => {
            console.log("Disconnected from WebSocket server");
        };

        socket.onerror = (error) => {
            console.error("WebSocket error:", error);
        };

        function openChet(user){
            window.location.href="chat.php?user="+user;
        }
        function change(username, newUnreadCount) {
            // Select all chat items
            const un_re = document.getElementById(''+username+'un');
            
            if(newUnreadCount>0){
                un_re.innerText=newUnreadCount;
                un_re.classList.remove('hide');
            }


            // Loop through each chat item
            // chatItems.forEach(item => {
            //     // Check if the onclick attribute contains the username
            //     if(newUnreadCount>0){
            //         if (document.getElementById(''+username+un+'')) {
            //             // Find the un_read element within the selected chat item and update its value
            //             const unreadElement = item.querySelector('.un_read');
            //             if (unreadElement) {
            //                 unreadElement.classList.remove('hide');
            //                 unreadElement.innerHTML = newUnreadCount;
            //             }
            //         }
            //     }else{
                    
            //     }
            // });
        }

        function newMessage(username, newMessage) {
            // Select all elements with the class "chat-item"
            const chatItems = document.querySelectorAll('.chat-item');
            
            // Loop through each chat item to find the one with the specified username
            chatItems.forEach(item => {
                const nameElement = item.querySelector('#username');
                
                // Check if the username matches
                if (nameElement && nameElement.textContent === username) {
                    // Find the element with the class "new" and change its content
                    const newElement = item.querySelector('.new');
                    if (newElement) {
                        // Set the new message
                        newElement.innerHTML = newMessage;
                        
                        // Add the fade-in class
                        newElement.classList.add('fade-in');
                        
                        // Remove the fade-in class after animation ends
                        setTimeout(() => {
                            newElement.classList.remove('fade-in');
                        }, 500); // Duration matches the animation duration in CSS
                    }
                }
            });
        }



    </script>
</body>
</html>