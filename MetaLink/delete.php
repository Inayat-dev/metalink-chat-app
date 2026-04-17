<?php
    include 'config.php';

    
    $name = $_COOKIE['username'];
    $friend = $_POST['req'];

    if($conn){
        
        $delete = mysqli_query($conn, 'DELETE FROM request WHERE sender="'.$friend.'" AND reciver="'.$name.'"');
        if($delete){
            header("Location: requests.php");
        }

    }else{
        echo "error page not found";
    }
?>