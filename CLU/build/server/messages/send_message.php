<?php
session_start();
require_once("../connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $senderId = $_SESSION['user_id'];
    $receiverId = $_POST['follower_id'];
    $message = $_POST['message'];

   



    // Insert message into the database
    $sql = "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'iis', $senderId, $receiverId, $message);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Message sent successfully";
    } else {
        echo "Error: " . mysqli_error($connect);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
?>
