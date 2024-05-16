<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    include_once('../connect.php'); 

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT users.user_id, users.username, users.email, users.profile_pic_url 
            FROM followers 
            INNER JOIN users ON followers.following_id = users.user_id 
            WHERE followers.follower_id = $user_id";

    $result = mysqli_query($connect, $sql);

    if ($result) {
        $friends = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $friends[] = $row;
        }

        echo json_encode($friends);
    } else {
        $response = array('success' => false, 'message' => 'Error fetching friends.');
        echo json_encode($response);
    }

    mysqli_close($connect);
} else {
    $response = array('success' => false, 'message' => 'You must be logged in to fetch friends.');
    echo json_encode($response);
}
?>
