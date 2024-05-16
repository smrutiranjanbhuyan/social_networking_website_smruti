<?php
session_start();
require_once '../connect.php'; 

$response = array(); // Initialize response array

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch followers of the current user
    $query = "SELECT u.user_id, u.username, u.profile_pic_url FROM users u
              INNER JOIN followers f ON u.user_id = f.follower_id
              WHERE f.following_id = $user_id";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $followers = array(); // Initialize array to store followers
        while ($row = mysqli_fetch_assoc($result)) {
            // Append follower data to the followers array
            $followers[] = array(
                'user_id' => $row['user_id'],
                'username' => $row['username'],
                'profile_pic_url' => $row['profile_pic_url']
            );
        }
        $response['success'] = true;
        $response['followers'] = $followers; 
    } else {
        $response['success'] = false;
        $response['error'] = "Error fetching followers: " . mysqli_error($connect);
    }
} else {
    $response['success'] = false;
    $response['error'] = "User not logged in";
}

// Return the JSON response
echo json_encode($response);
?>
