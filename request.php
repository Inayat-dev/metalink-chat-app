<?php
    include 'config.php';
    
    $sender = $_COOKIE['username'];
    $reciver = $_GET['reciver'];
    $date = $_GET['time'];
    if($conn){

        $insert = mysqli_query($conn, 'INSERT INTO request(sender,reciver,time) VALUES("'.$sender.'", "'.$reciver.'", "'.$date.'")');
        
        if($insert){
            
            echo json_encode(["data" => "success"]);
        }
    }
?>