<?php
include 'config.php';
$id = $_GET['id'];
$username = $_GET['username'];

function check_user($conn, $id_status, $username_view) {
    $check = mysqli_query($conn, "SELECT status_id, username FROM seen WHERE status_id = $id_status AND username = '$username_view'");
    while ($row = $check->fetch_assoc()) {
        if ($row['status_id'] == $id_status && $row['username'] == $username_view) {
            return false; 
        }
    }
    return true; 
}

$data = "";

if (isset($id) && isset($username) && check_user($conn, $id, $username)) {
    $seen = mysqli_query($conn, "INSERT INTO seen(status_id, username) VALUES ('$id', '$username')");
    if ($seen) {
        $update = mysqli_query($conn,"UPDATE status SET seen =1+seen WHERE id=$id");
        if($update){
            $data = json_encode(["response" => "success"]);
        }
    } else {
        $data = json_encode(["response" => "error"]);
    }
} else {
    $data = json_encode(["response" => "user already exists"]);
}

echo $data;
?>
