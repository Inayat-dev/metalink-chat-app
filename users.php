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

        .total_un {
            background-color: #02db53;
            width: 17px;
            height: 17px;
            font-size: 12px;
            border-radius: 50px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate3d(11px, 9px, 0px);
        }

        .hide {
            display: none;
        }

        .status span {
            font-weight: 900;
        }

        .bottom-nav .icon {
            color: #fff;
            font-size: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .bottom-nav .icon:hover {
            color: #25d366;
        }

        .bottom-nav .icon-label {
            font-size: 0.8rem;
            margin-top: 3px;
            color: #ddd;
        }

        .active {
            color: #25d366;
        }

        .status {
            background-color: #25d366;
            width: 45px;
            height: 45px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .chat-list {
            padding-bottom: 100px;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .chat-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-info h5 {
            margin: 0;
            font-size: 1rem;
            color: #333;
        }

        .chat-info p {
            margin: 0;
            font-size: 0.8rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="search-bar">
        <input type="text" placeholder="Search your chat" id="searchInput">
    </div>

    <div class="chat-list" id="chatList"></div>

    <div class="bottom-nav">
        <div class="icon" onclick="window.location.href='home.php'">
            <span class="online total_un hide" id="total_un">
                <?php
                    include 'config.php';
                    $all_un = mysqli_query($conn, "SELECT un_read FROM friends WHERE name='" . $_COOKIE['username'] . "'");
                    $total_unread = 0;
                    while ($row = $all_un->fetch_assoc()) {
                        $total_unread += $row['un_read'];
                    }
                    echo $total_unread;
                ?>
            </span>
            <i class="fas fa-comments"></i>
            <span class="icon-label">Chat</span>
        </div>
        <div class="icon active" style="color:#25d366;" onclick="window.location.href='Users.php'">
            <i class="fas fa-users"></i>
            <span class="icon-label" style="color:#25d366;">Users</span>
        </div>
        <div class="icon status" onclick="window.location.href='status_upload.php'">
            <span style="font-size: 50px;">+</span>
        </div>
        <div class="icon" onclick="window.location.href='requests.php'">
            <?php
                    $all_un = mysqli_query($conn, "SELECT * FROM request WHERE reciver='" . $_COOKIE['username'] . "'");
                    ;
                    
                    if($all_un->num_rows>0)
                        echo '<span class="online total_un " id="total_un">'.$all_un->num_rows.'</span>';
                ?>
            <i class="fas fa-envelope"></i>
            <span class="icon-label">Request</span>
        </div>
        <div class="icon" onclick="window.location.href='profile.php'">
            <i class="fas fa-user-circle"></i>
            <span class="icon-label">Profile</span>
        </div>
    </div>

    <script>
        let offset = 0;
        const limit = 50;
        const chatList = document.getElementById('chatList');
        const searchInput = document.getElementById('searchInput');

        function loadUsers(offset, limit, query = '') {
            fetch(`load_users.php?offset=${offset}&limit=${limit}&search=${query}`)
                .then(response => response.json())
                .then(users => {
                    users.forEach(user => {
                        const chatItem = createChatItem(user);
                        chatList.appendChild(chatItem);
                    });
                    if (users.length < limit) {
                        window.removeEventListener('scroll', loadMoreOnScroll);
                    }
                });
        }

        function createChatItem(user) {
            const chatItem = document.createElement('div');
            chatItem.className = 'chat-item';
            
            // Determine button text and styles based on user status
            let buttonText = 'Request';
            let buttonStyle = 'color:white;background-color:#49bcffd2;border:none;border-radius:3px;padding:0 6px;';
            if (user.requ === 'requested') {
                buttonText = 'Cancle';
                buttonStyle = 'color:white;background-color:red;border:none;border-radius:3px;padding:0 6px;';
            }

            console.log(user)

            chatItem.innerHTML = `
                <img src="${user.profile_image || 'profile/default.jpg'}" alt="Profile Image">
                <div class='chat-info'>
                    <h5 style="color:#25d366;">${user.username}</h5>
                    <p>${user.bio}</p>
                </div>
                <div class='chat-time'>
                        <button name='reciver' id="request" onclick="${(user.requ != 'requested')?"request('"+user.username+"',this)":"delete_request('"+user.username+"',this)"}" value='${user.username}' style='${buttonStyle}' >${buttonText}</button>
                    <p class='${user.status}'>${user.status === 'online' ? '' : ''}</p>
                </div>
            `;

           

            return chatItem;
        }

        async function request(reciver,button){
            let now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            let time = `${hours}:${minutes}`;
            let data = await fetch('request.php?reciver='+reciver+'&time='+time);
            data = await data.json()
            if(data.data == "success"){
                button.style.background = "red"
                button.innerHTML="Cancle";
                button.setAttribute('onclick','delete_request("'+reciver+'",this)')
            }
        }

        async function delete_request(reciver,button){
            console.log("requesting......")
            let data =  await fetch('delete_request.php?reciver='+reciver);
            data = await data.json()
            console.log("\nreceived");
            if(data.data == 'success'){
                console.log("changed");
                button.style.background = "#49bcffd2"
                button.innerHTML="Request";
                button.setAttribute('onclick','request("'+reciver+'",this)')
            }
        }


        function loadMoreOnScroll() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                offset += limit;
                loadUsers(offset, limit, searchInput.value);
            }
        }

        searchInput.addEventListener('input', () => {
            offset = 0;
            chatList.innerHTML = '';
            loadUsers(offset, limit, searchInput.value.trim());
        });

        window.addEventListener('scroll', loadMoreOnScroll);
        loadUsers(offset, limit);
    </script>
</body>
</html>
