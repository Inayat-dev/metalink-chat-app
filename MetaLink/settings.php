<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    
    <style>
        h2{
            margin: 40px 0 0 10px;
            color: white;
        }

        .settings-options{
            margin-top: 40px;
            display: flex;
            flex-direction: column;
        }

        .settings-options a{
            color: #02db53;
            padding: 20px 0 5px 10px;
            width: 100%;
            margin: 0px 0 0 0;
            text-decoration: none;
            background-color: transparent;
            border-radius: 0 0 10px 10px;
            border-bottom: 1px solid white;
            transition: .3s;
        }

        .settings-options a:hover{
            transition: background-color 1s;
            background-color: #000a10;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="profile-container settings-container">
        <div class="profile-header">
            <h2>Settings</h2>
        </div>
        <div class="settings-options">
            <a href="Email.php" class="settings-button">Change Email</a>
            <a href="Password.php" class="settings-button">Change Password</a>
        </div>
    </div>
</body>
</html>
