<?php
    include 'config.php';
    $friend = $_POST['friend'];
    $myname = $_COOKIE['username'];

    $delete_user=mysqli_query($conn,"DELETE FROM friends WHERE (name = '$myname' AND myfriend = '$friend') OR (myfriend = '$myname' AND name = '$friend')");
    if($delete_user) 
        $delete_chat=mysqli_query($conn,"DELETE FROM messages WHERE (sender = '$myname' AND reciver = '$friend') OR (reciver = '$myname' AND sender = '$friend')");
    if($delete_chat)
        header('Location:home.php')
?>