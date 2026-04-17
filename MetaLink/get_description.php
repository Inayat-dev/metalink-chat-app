<?php
include 'config.php';

$status_id = $_GET['status_id'];
$response = [];

// Query to fetch descriptions based on status_id
$query = mysqli_query($conn, "SELECT username, description FROM seen WHERE status_id = '$status_id'");

// Fetch results only if descriptions exist
if ($query && mysqli_num_rows($query) > 0) {
    while ($row = $query->fetch_assoc()) {
        
            $response[] = [
                "username" => $row['username'],
                "text" => $row['description']
            ];
        
    }
} else {
    // If no descriptions are found, you can return an empty array or a message
    $response = ["message" => "No descriptions available"];
}

// Return the descriptions in JSON format
echo json_encode($response);
?>
