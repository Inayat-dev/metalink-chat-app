<?php
    include 'config.php';

    
    $name = $_COOKIE['username'];
    $friend = $_POST['req'];

    if($conn){
        $insert = mysqli_query($conn,'INSERT INTO friends(name, myfriend) values("'.$name.'","'.$friend.'")');
        $insert = mysqli_query($conn,'INSERT INTO friends(myfriend, name) values("'.$name.'","'.$friend.'")');
        
        if($insert){
        }
        $delete = mysqli_query($conn, 'DELETE FROM request WHERE sender="'.$friend.'" AND reciver="'.$name.'"');
        if($delete){
            header("Location: requests.php");
        }

    }else{
        echo "error page not found";
    }
?>