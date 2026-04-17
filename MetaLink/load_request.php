<?php
include 'config.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 50; // Number of users to load per request
$offset = $page * $limit;

// Query to fetch users based on search and pagination
$sql = "SELECT * FROM request WHERE reciver = '".$_COOKIE['username']."' AND sender LIKE '%$search%' LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = ['name' => $row['sender']];
}

echo json_encode(['users' => $users]);
?>
