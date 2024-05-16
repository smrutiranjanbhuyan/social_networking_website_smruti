<?php
include('../connect.php');

function getCommentsForPost($connect, $post_id) {
    $query = "SELECT comments.*, users.username 
              FROM comments 
              INNER JOIN users ON comments.user_id = users.user_id
              WHERE comments.post_id = ?";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($statement, "i", $post_id);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($statement);
    return $comments;
}

if (isset($_GET['post_id'])) {
    $post_id = mysqli_real_escape_string($connect, $_GET['post_id']);
    $comments = getCommentsForPost($connect, $post_id);
    header('Content-Type: application/json');
    echo json_encode($comments);
} else {
    $_SESSION['errors'][] =  "Server connection failed "; 
    echo '<script>alert("Server connection failed"); window.location="../../404.php";</script>';
    header('HTTP/1.1 400 Bad Request');
    echo "Missing post_id parameter";
}

mysqli_close($connect);
?>
