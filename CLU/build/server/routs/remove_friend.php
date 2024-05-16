<?php
session_start();

if (isset($_SESSION['user_id'])) {
    include_once('../connect.php'); 

    if (isset($_POST['user_id']) && isset($_POST['friend_id'])) {
        // Retrieve user and friend IDs from the POST data and convert them to integers
        $user_id = intval($_POST['user_id']);
        $friend_id = intval($_POST['friend_id']);

        // Check if the user is trying to unfollow themselves
        if ($user_id == $friend_id) {
            $response = array('success' => false, 'message' => 'You cannot unfollow yourself.');
            echo json_encode($response);
            exit;
        }

        // Check if the user is already following the friend
        $check_query = "SELECT * FROM followers WHERE follower_id = $user_id AND following_id = $friend_id";
        $check_result = mysqli_query($connect, $check_query);
        if (mysqli_num_rows($check_result) == 0) {
            $response = array('success' => false, 'message' => 'You are not following this user.');
            echo json_encode($response);
            exit;
        }

        $delete_query = "DELETE FROM followers WHERE follower_id = $user_id AND following_id = $friend_id";
        if (mysqli_query($connect, $delete_query)) {
            $response = array('success' => true);
            echo json_encode($response);
            exit;
        } else {
            $response = array('success' => false, 'message' => 'Error unfollowing user. Please try again later.');
            echo json_encode($response);
            exit;
        }
    } else {
        $response = array('success' => false, 'message' => 'User ID or friend ID not provided.');
        echo json_encode($response);
        exit;
    }
} else {
    $response = array('success' => false, 'message' => 'You must be logged in to unfollow users.');
    echo json_encode($response);
    exit;
}
?>
