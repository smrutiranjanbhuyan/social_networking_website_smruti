<?php

include '../connect.php';

if (isset($_GET['post_id'])) {

    $post_id = mysqli_real_escape_string($connect, $_GET['post_id']);

    // Fetch the count of likes
    $query = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = $post_id";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $like_count = $row['like_count'];

        // Fetch usernames of users who liked the post
        $query_users = "SELECT u.username
                        FROM likes l
                        INNER JOIN users u ON l.user_id = u.user_id
                        WHERE l.post_id = $post_id";
        $result_users = mysqli_query($connect, $query_users);
        $liked_users = array();
        while ($row_users = mysqli_fetch_assoc($result_users)) {
            $liked_users[] = $row_users['username'];
        }

        // Return the like count and the usernames
        $response = array(
            'like_count' => $like_count,
            'liked_users' => $liked_users
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Query failed
        echo 'Error: Unable to fetch likes';
    }
} else {
    // Post ID not provided
    echo 'Error: Post ID is required';
}

?>
