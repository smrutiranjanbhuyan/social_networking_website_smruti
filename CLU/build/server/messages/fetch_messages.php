<?php
session_start();
require_once("../connect.php");

if (isset($_SESSION['user_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    
    $sql = "SELECT messages.*, 
               users.username AS sender_name,
               users.profile_pic_url AS sender_profile_pic, 
               CASE WHEN messages.sender_id = ? THEN 'sender' ELSE 'messenger' END AS message_from 
        FROM messages 
        INNER JOIN users ON messages.sender_id = users.user_id
        WHERE (messages.sender_id = ? AND messages.receiver_id = ?) OR (messages.sender_id = ? AND messages.receiver_id = ?) 
        ORDER BY messages.created_at ASC";

    $stmt = $connect->prepare($sql);
    $stmt->bind_param("iiiii", $sender_id, $sender_id, $receiver_id, $receiver_id, $sender_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = array();
    
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    
    echo json_encode($messages);
} else {
    echo json_encode(array("error" => "User not logged in"));
}
?>
