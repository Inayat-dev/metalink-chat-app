<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
    <style>
        h2{
            color: #02db53;
            margin: 20px 0 30px 10px;
        }

        .form-group{
            color: #02db53;
            padding: 30px 0 0px 1px;
            width: 100%;
            margin: 0px 0 0 0;
            text-decoration: none;
            background-color: transparent;
            border-bottom: 1px solid white;
            display: flex;
            justify-content: space-between;
            
        }

        .form-group label{
            margin-bottom: 0;
            padding-top: 0;
            
        }

        .form-group input{
            width: 70%;
            color: white;
            height: 40px;
            border: none;
            border-radius: 10px 10px 0 0 ;
            transition: .3s;
            background-color: #000a10;
        }

        .form-group input:hover{
            padding: 10px;
            transition: all 0.3s;
        }

        .button_div{
            width: 100%;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .submit-button{
            border: none;
            color: white;
            padding: 10px;
            border-radius: 10px;
            transition: .3s;
            background-color: #02db53;
        }

        .submit-button:hover{
            transition: all .3s;
            box-shadow: 0 0 3px 1px #02db53;
            padding: 14px;
            
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Change Password</h2>
        </div>
        <form action="processPasswordChange.php" method="POST">
            <div class="form-group">
                <label for="oldPassword">Old Password:</label>
                <input type="password" name="oldPassword" id="oldPassword" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password:</label>
                <input type="password" name="newPassword" id="newPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required>
            </div>
            <div class="button_div">
                <button type="submit" class="submit-button">Update Password</button>
            </div>
            
        </form>
    </div>
</body>
</html>
