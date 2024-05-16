<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Include database connection
    include_once('../connect.php'); 

   
    if (isset($_POST['user_id']) && isset($_POST['friend_id'])) {
       
        $user_id = intval($_POST['user_id']);
        $friend_id = intval($_POST['friend_id']);

     
        if ($user_id == $friend_id) {
         
            $response = array('success' => false, 'message' => 'You cannot add yourself as a friend.');
            echo json_encode($response);
            exit;
        }

      
        $check_query = "SELECT * FROM followers WHERE follower_id = $user_id AND following_id = $friend_id";
        $check_result = mysqli_query($connect, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            
            $response = array('success' => false, 'message' => 'You are already following this user.');
            echo json_encode($response);
            exit;
        }

      
        $insert_query = "INSERT INTO followers (follower_id, following_id) VALUES ($user_id, $friend_id)";
        if (mysqli_query($connect, $insert_query)) {
            
            $response = array('success' => true);
            echo json_encode($response);
            exit;
        } else {
           
            $response = array('success' => false, 'message' => 'Error adding friend. Please try again later.');
            echo json_encode($response);
            exit;
        }
    } else {
      
        $response = array('success' => false, 'message' => 'User ID or friend ID not provided.');
        echo json_encode($response);
        exit;
    }
} else {
    // Return an error response if the user is not logged in
    $response = array('success' => false, 'message' => 'You must be logged in to add friends.');
    echo json_encode($response);
    exit;
}
?>
