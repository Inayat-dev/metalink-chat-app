<?php
// Connect to the database
include 'config.php';

if (isset($_GET['status_id'])) {
    $status_id = $_GET['status_id'];

    // Fetch status information
    $status_query = mysqli_query($conn, "SELECT * FROM status WHERE id='$status_id'");
    $status = mysqli_fetch_assoc($status_query);

    // Fetch comments for the specific status
    $comments_query = mysqli_query($conn, "SELECT username, description FROM seen WHERE status_id='$status_id' ");
} else {
    echo "Status ID not specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Comments</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #111b21;
            color: #ddd;
            font-family: Arial, sans-serif;
        }

        .status-container {
            max-width: 600px;
            margin: 30px auto;
            background: #202c33;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .status-video {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 14px 3px #000;
        }

        .comments-section {
            margin-top: 20px;
        }

        .comment-item {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 8px;
            background: #2a3942;
            border-radius: 5px;
        }

        .comment-item .username {
            font-weight: bold;
            color: #25d366;
            margin-right: 8px;
        }

        .comment-item .text {
            color: #ddd;
        }

        .add-comment {
            display: flex;
            margin-top: 15px;
        }

        .add-comment input[type="text"] {
            flex: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #444;
            background: #1c1c1c;
            color: #ddd;
            outline: none;
        }

        .add-comment button {
            background-color: #25d366;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            margin-left: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="status-container">
    <!-- Display the status video -->
    <video class="status-video" src="status/<?php echo $status['video_name']; ?>" controls autoplay loop></video>

    <div class="comments-section">
        <h3>Comments</h3>

        <!-- Display each comment -->
        <?php while ($comment = mysqli_fetch_assoc($comments_query)) : ?>
            <div class="comment-item">
                <span class="username"><?php echo htmlspecialchars($comment['username']); ?>:</span>
                <span class="text"><?php echo htmlspecialchars($comment['description']); ?></span>
            </div>
        <?php endwhile; ?>

        <!-- Add a new comment form -->
        
    </div>
</div>

</body>
</html>
