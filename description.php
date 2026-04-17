<?php
include 'config.php';
$id = $_GET['id'];
$username = $_GET['username'];
$description =$_GET['description'];

function check_user($conn, $id_status, $username_view) {
    $check = mysqli_query($conn, "SELECT status_id, username FROM seen WHERE status_id = $id_status AND username = '$username_view'");
    while ($row = $check->fetch_assoc()) {
        if ($row['status_id'] == $id_status && $row['username'] == $username_view) {
            return true; 
        }
    }
    return false; 
}

$data = "";

if (isset($id) && isset($username) && check_user($conn, $id, $username)) {
    $seen = mysqli_query($conn, "UPDATE seen SET description = '$description' WHERE username ='$username'");
    if ($seen) {
        $data = json_encode(["response" => "success"]);
    } else {
        $data = json_encode(["response" => "error"]);
    }
} else {
    $data = json_encode(["response" => "not seen"]);
}

echo $data;
?>
