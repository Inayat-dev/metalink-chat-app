<?php
    include 'config.php';
    $sender = $_COOKIE['username'];
    $receiver = $_GET['reciver'];

    $delete = mysqli_query($conn,"DELETE FROM request WHERE (sender = '$sender' AND reciver = '$receiver') OR (reciver = '$sender' AND sender = '$receiver')");
    if($delete){
        echo json_encode(["data"=>"success"]);
    }
?>