<?php
    include 'config.php';

    $username = $_GET['username'];
    $check = mysqli_query($conn,"SELECT username from users where username = '$username'");

    if($check->num_rows==0){
        echo json_encode(["username"=>"done"]);
    }else{
        echo json_encode(["username"=>"sorry"]);
    }
?>