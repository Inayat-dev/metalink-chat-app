<?php
include 'config.php';

$current_user = $_COOKIE['username'];
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query with pagination and optional search
$sql = "
    SELECT u.username, u.profile_image, u.bio, u.status,
    CASE 
        WHEN r.sender IS NOT NULL THEN 'requested'
        ELSE 'available'
    END AS requ
    FROM Users u
    LEFT JOIN request r ON (r.sender = u.username AND r.reciver = '$current_user') OR (r.reciver = u.username AND r.sender = '$current_user')
    WHERE u.username != '$current_user'
    AND u.username LIKE '%$search%'
    AND u.username NOT IN (
        SELECT f.myfriend FROM friends f WHERE f.name = '$current_user'
        UNION
        SELECT f.name FROM friends f WHERE f.myfriend = '$current_user'
    )
    LIMIT $offset, $limit
";

$result = $conn->query($sql);
$users = [];
$pre="null";
if ($result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        if($pre!=$user['username']){
            $users[] = $user;
        }
        $pre=$user['username'];
            
    }
}
echo json_encode($users);
$conn->close();
?>
