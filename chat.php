<?php
include 'config.php';
    $sql = "SELECT * FROM users WHERE username = '".$_GET['user']."' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        
        $user = mysqli_fetch_assoc($result);
    
        
        
    } else {
        echo "No user found with that username.";
    }


    $un_read=mysqli_query($conn,"SELECT un_read FROM friends WHERE name = '".$_COOKIE['username']."' AND myfriend='".$user['username']."'");
    
    $row=$un_read->fetch_assoc();
    if(isset($row['un_read'])){
        $un_read=$row['un_read'];
        $all_un=mysqli_query($conn,"SELECT un_read FROM friends WHERE name='".$_COOKIE['username']."'");
            $total_unread=0;
            while($row=$all_un->fetch_assoc()){
                $total_unread+=$row['un_read'];
            }
        $read_all = mysqli_query($conn,"UPDATE users SET un_read_messages='".$total_unread-$un_read."' WHERE username='".$_COOKIE['username']."'");
    }else{
        $block="Blocked Users Can't Send Messages ";
    }

    
    $insert_window = mysqli_query($conn,"UPDATE users SET user_window='".$user['username']."' where username='".$_COOKIE['username']."'");
   
    $read_all = mysqli_query($conn,"UPDATE friends SET un_read=0 WHERE name='".$_COOKIE['username']."'");

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <style>
            /* General body and layout styling */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #111b21;
            color: #fff;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            max-width: 500px;
            margin: auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.7);
        }

        /* Header styling */
        .header {
            display: flex;
            align-items: center;
            background-color: #202c33;
            padding: 5px;
            border-bottom: 1px solid #333;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .back-arrow {
            cursor: pointer;
            margin-right: 15px;
            transition: transform 0.3s;
        }

        .back-arrow i {
            color: #fff;
            font-size: 1.8rem;
        }

        .back-arrow:hover i {
            transform: scale(1.1);
            color: #25d366;
        }

        .menu{
            transform: rotate(90deg);
            font-size: 130%;
            cursor: pointer;
            margin-left: auto;
        }

        .profile-image {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid #25d366;
        }

        /* Chat window styling */
        .chat-window {
            flex-grow: 1;
            padding: 20px;
            background-color: #1f262b;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            
            scroll-behavior: smooth;
        }

        .chat-window::-webkit-scrollbar{
            display: none;
        }

        /* Message styling */
        .message {
            max-width: 70%;
            padding: 5px 15px;
            border-radius: 20px;
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
        }

        .message-sender {
            font-weight: bold;
            font-size: 1rem;

        }

        .message-text {
            padding: 1px;
            border-radius: 7px;
            font-size: 1rem;
            line-height: 1.5;
            position: relative;
            max-width: 190px;
        }

        .message-time {
            font-size: 0.7rem;
            color: #fff;
            text-align: right;
            margin-top: 5px;
            opacity: 0.8;
        }

        /* Sent and received message alignment and colors */
        .message.sent {
            align-self: flex-end;
            background-color: #25d366;
            color: #fff;
            border-top-right-radius: 0;
            text-align: left;
            box-shadow: 0px 3px 6px rgba(37, 211, 102, 0.3);
        }

        .message.sent .message-text {
            background-color: #25d366;
        }

        .message.received {
            align-self: flex-start;
            background-color: #3a3d3d;
            color: #fff;
            border-top-left-radius: 0;
            text-align: left;
            box-shadow: 0px 3px 6px rgba(58, 61, 61, 0.3);
        }

        .message.received .message-text {
            background-color: #3a3d3d;
        }

        /* Message input styling */
        .message-input {
            display: flex;
            padding: 15px;
            background-color: #202c33;
            border-top: 1px solid #333;
        }

        .message-input textarea {
            flex-grow: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 25px;
            background-color: #ffffff20;
            color: #fff;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .message-input textarea:focus {
            background-color: #ffffff30;
            outline: none;
        }

        .message-input button {
            padding: 12px;
            border: none;
            border-radius: 50px;
            background-color: #25d366;
            color: #fff;
            margin-left: 10px;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            font-size: 1.2rem;
        }

        .menu-sidebar {
            position: fixed;
            top: 0;
            right: -300px; /* Start off-screen */
            width: 250px;
            height: 100%;
            background-color: #202c33;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            padding: 20px 0 0 0;
            transition: right 0.3s ease-in-out;
            z-index: 20;
        }

        .menu-sidebar .close-menu {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #fff;
            cursor: pointer;
            margin-bottom: 20px;
            align-self: flex-end;
        }

        .menu-sidebar .menu-option {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #d9534f; /* Red color for delete */
            color: #fff;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .menu-sidebar .menu-option:hover {
            background-color: #c9302c;
        }

        /* Show menu when it is toggled */
        .menu-sidebar.show {
            right: 0;
        }


        .message-input button:hover {
            transform: scale(1.1);
            background-color: #1da954;
        }


        .scroll{
            width: 30px;
            height: 30px;
            color: white;
            background-color: rgb(31, 150, 255);
            border: none;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate3d( 15px ,-15vh ,0);
            position: fixed;
            bottom: 0;
        }

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

        .menu-sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #25d366;
            display: block;
            transition: 0.3s;
        }

        .menu-sidebar a:hover {
            background-color: #333;
        }

        .menu-sidebar .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            color: #25d366;
            cursor: pointer;
        }


        .hide{
            visibility: hidden;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
    <!-- <link rel="stylesheet" href="Cstyle.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <div class="chat-container">
        <div class="header">
            <div class="back-arrow" >
                &nbsp;&nbsp;<a href="home.php"><i class="fas fa-arrow-left" style="font-size: 130%;"></i></a>
            </div>
            
            <?php
                if ($user['profile_image'] != "") {
                    echo "<img src='" . $user['profile_image'] . "' onclick=\"window.location.href='user_profile.php?username=". $user['username']."'\" class='profile-image'>";
                } else {
                    echo '<img src="profile/default.jpg"  onclick="window.location.href=\'user_profile.php?username='. $user['username'].'" class="profile-image" >';
                }
            ?>
            <h2><div class="message-sender"  onclick="window.location.href='user_profile.php?username=<?php echo $user['username'];?>'"><?php
                    echo $user['username'];
                    
                ?></div>
                <div class="time" style="color: #bbb;font-size:10px;" onclick="window.location.href='user_profile.php?username=<?php echo $user['username']?>'">
                    <?php
                        if($user['bio']!=""){
                            echo $user['bio'];
                        }else{
                            echo "Hey! I'm here on Metalink to chat, connect, and keep in touch. Let’s link up!";
                        }
                    ?>
                </div>    
            </h2>
                
                    <i class="fa-solid fa-ellipsis menu" onclick="toggleMenu()"></i>
            </div>

            <!-- Sidebar menu -->
            <div class="menu-sidebar side bar" id="menuSidebar">
                <button class="close-menu" onclick="toggleMenu()">×</button>
                <a href="user_profile.php?username=<?php echo $user['username'];?>" lass="menu-option">User Profile</a>
                <form action="block.php" method="post">
                    <button type="submit" name="friend" value="<?php echo $user['username']?>" class="menu-option" >Block User</button>
                </form>
                
            </div>
        <div class="chat-window" id="chatWindow">
        <?php
                if(isset($block)){
                    echo $block;
                }
            ?>
        <?php
            include 'config.php';

            $query = "SELECT sender, reciver, message, time FROM messages";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    if($row['reciver']==$_COOKIE['username'] && $row['sender']==$user['username'] || $row['sender']==$_COOKIE['username'] && $row['reciver']==$user['username']){
                        if($row['sender'] != $user['username']){
                            echo '<div class="message sent" >';
                                echo '<div class="message-sender">You</div>';
                                echo '<div class="message-text">'.$row['message'].'</div>';
                                echo '<div class="message-time">'.$row['time'].'</div>';
                                
                            echo '</div>';
                        }else{
                            echo '<div class="message received">';
                                echo '<div class="message-sender">'.$row['sender'].'</div>';
                                echo '<div class="message-text">'.$row['message'].'</div>';
                                echo '<div class="message-time">'.$row['time'].'</div>';
                            echo '</div>';
                        }
                    }
                }
            } else {
                echo "Most secure plateform ";
            }
            ?>

        <!-- <div class="message">
                <div class="message-sender">Mobbyyy</div>
                <div class="message-text">What was the best year of your life?</div>
                <div class="message-time">04:01</div>
            </div>
            <div class="message received">
                <div class="message-sender">You</div>
                <div class="message-text">I would say 2020 was a great year!</div>
                <div class="message-time">04:02</div>
            </div>
            <div class="message">
                <div class="message-sender">Mobbyyy</div>
                <div class="message-text">Glad to hear that!</div>
                <div class="message-time">04:03</div>
            </div> -->
            <!-- Additional messages can go here -->
            <button class="scroll hide" onclick="readall(this)" id="un_read"></button>
        </div>
        
        <div class="message-input">
            
            <textarea name="message" id="message"></textarea>
            <button onclick="sendMessage()" >Send</button>
        </div>
    </div>

    <script >
        let sender = "<?php echo $_COOKIE['username']; ?>";
        let receiver = "<?php echo $user['username']; ?>";
        
        let un_read = "<?php echo $un_read;?>"
        
        if(un_read>0){
            document.getElementById('un_read').classList.remove('hide')
            document.getElementById('un_read').innerHTML=un_read;
            scrollChatToLastNMessages();
        }
        
        const elem = document.documentElement; 
        

        function scrollToBottom() {
            const chatWindow = document.getElementById('chatWindow');
            chatWindow.scrollTop = chatWindow.scrollHeight;
        }

        

        async function readall(button){
            button.classList.add('hide');
            console.log(button.classList)
            scrollToBottom();
        }

        function toggleMenu() {
            const menuSidebar = document.getElementById('menuSidebar');
            menuSidebar.classList.toggle('show');
        }

        function scrollChatToLastNMessages() {
            const chatWindow = document.getElementById('chatWindow');
            const messages = chatWindow.querySelectorAll('.message');
            let n = parseInt(un_read)+2;
            console.log(n);
            
            if (messages.length <= n) {
                chatWindow.scrollTop = chatWindow.scrollHeight;
                return;
            }

            const lastMessageIndex = messages.length - 1;
            const nthLastMessageIndex = lastMessageIndex - (n - 1);
            const lastMessage = messages[lastMessageIndex];
            const nthLastMessage = messages[nthLastMessageIndex];

            const nthLastInView = nthLastMessage.getBoundingClientRect().top >= chatWindow.getBoundingClientRect().top;
            const lastMessageInView = lastMessage.getBoundingClientRect().bottom <= chatWindow.getBoundingClientRect().bottom;

            if (!nthLastInView || !lastMessageInView) {
                chatWindow.scrollTop = nthLastMessage.offsetTop - chatWindow.clientHeight + nthLastMessage.clientHeight;
            }
        }


        function deleteChat() {
            if (confirm("Are you sure you want to delete this chat?")) {
                alert("Chat deleted.");
              
            }
            toggleMenu(); 
        }


        
        const username = document.cookie.replace(/(?:(?:^|.*;\s*)username\s*\=\s*([^;]*).*$)|^.*$/, "$1");
        //const socket = new WebSocket(`ws://localhost:8000?username=${username}`);
        const socket = new WebSocket(`ws://<?php $parts = explode(':', $_SERVER['HTTP_HOST']);
$ip_only = $parts[0]; echo $ip_only;?>:8000?username=${username}`);
        socket.onopen = () => {
            console.log("Connected to WebSocket server");
        };

        socket.onmessage = (event) => {
            let data=JSON.parse(event.data);
            console.log("Message from server:", data);
            let chat = document.getElementById('chatWindow');
            let chat_data;
            
                if(sender == data.sender){
                chat_data=`
                    <div class="message sent " >
                        <div class="message-sender ">You</div>
                        <div class="message-text">${data.message}</div>
                        <div class="message-time">${data.time}</div>
                    </div>
                `;
                chat.innerHTML += chat_data;
            }else{
                if(receiver == data.sender){
                    chat_data=`
                    <div class="message received">
                        <div class="message-sender">${data.sender}</div>
                        <div class="message-text">${data.message}</div>
                        <div class="message-time">${data.time}</div>
                    </div>
                `;
                chat.innerHTML += chat_data;
                }
            }
            scrollToBottom(0)
            

        };

        socket.onclose = () => {
            console.log("Disconnected from WebSocket server");
        };

        socket.onerror = (error) => {
            console.error("WebSocket error:", error);
        };

        function sendMessage() {
            let now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            let time = `${hours}:${minutes}`;
            const message = document.getElementById('message').value;
            document.getElementById('message').value="";
            socket.send(JSON.stringify({ sender: sender,receiver : receiver, message: message,time:time }));
        }
    </script>

</body>
</html>
