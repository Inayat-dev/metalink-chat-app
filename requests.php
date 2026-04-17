<?php
// Database connection
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic styling */
        .search-bar {
            padding: 5px;
            background-color: #202c33;
            display: flex;
            justify-content: center;
        }

        .search-bar input {
            width: 90%;
            padding: 2px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
        }

        .chat-list {
            padding: 20px;
        }

        .chat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #333;
            color: #fff;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .chat-item h5 {
            margin: 0;
            font-size: 1rem;
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
    </style>
</head>
<body>
    <div class="search-bar">
        <input type="text" id="search-input" placeholder="Search users">
    </div>

    <div class="chat-list" id="chat-list">
        <!-- User list will be populated here -->
    </div><br><br><br><br>

    <div class="bottom-nav">
        <div class="icon" onclick="window.location.href='home.php'">
            <i class="fas fa-comments"></i>
            <span class="icon-label">Chat</span>
        </div>
        <div class="icon" onclick="window.location.href='Users.php'">
            <i class="fas fa-users"></i>
            <span class="icon-label">Users</span>
        </div>
        <div class="icon status" onclick="window.location.href='status_upload.php'">
            <span style="font-size: 50px;">+</span>
        </div>
        <div class="icon" style="color:#25d366;" onclick="window.location.href='requests.php'">
            <i class="fas fa-envelope"></i>
            <span class="icon-label" style="color:#25d366;">Request</span>
        </div>
        <div class="icon" onclick="window.location.href='profile.php'">
            <i class="fas fa-user-circle"></i>
            <span class="icon-label">Profile</span>
        </div>
    </div>

    <script>
        let page = 0;
        const chatList = document.getElementById("chat-list");
        const searchInput = document.getElementById("search-input");

        // Function to load users
        function loadUsers(searchQuery = "") {
            fetch(`load_request.php?page=${page}&search=${searchQuery}`)
                .then(response => response.json())
                .then(data => {
                    data.users.forEach(user => {
                        const chatItem = document.createElement("div");
                        chatItem.className = "chat-item";
                        chatItem.innerHTML = `
                            <div class='chat-info'>
                                <h5>${user.name}</h5>
                            </div>
                            <div class='chat-time'>
                                <form action='accept.php' method='post'>
                                    <button type="submit" value="${user.name}" name="req" style="background: #49bcffd2; color: white; border: none; border-radius: 2px; margin: 0 4px 10px 0; height: 20px; width: 70px;">Accept</button>
                                </form>
                                <form action='delete.php' method='post'>
                                    <button type="submit" value="${user.name}" name="req" style="background: red; color: white; border: none; border-radius: 2px; margin: 0 4px 0 0; height: 20px; width: 70px;">Cancle</button>
                                </form>
                            </div>`;
                        chatList.appendChild(chatItem);
                    });
                    page++;
                });
        }

        // Load initial users
        loadUsers();

        // Infinite scroll to load users as you scroll down
        window.addEventListener("scroll", () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                loadUsers(searchInput.value);
            }
        });

        // Search functionality
        searchInput.addEventListener("input", () => {
            page = 0;
            chatList.innerHTML = ""; // Clear chat list for new search results
            loadUsers(searchInput.value);
        });
    </script>
</body>
</html>
