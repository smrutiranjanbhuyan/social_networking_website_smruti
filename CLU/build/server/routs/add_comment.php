<?php
include('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $comment_text = mysqli_real_escape_string($connect, $_POST['comment_text']);
    $post_id = mysqli_real_escape_string($connect, $_POST['post_id']);
    $user_id = mysqli_real_escape_string($connect, $_POST['user_id']);


    $query = "INSERT INTO comments (user_id, post_id, comment_text) VALUES (?, ?, ?)";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($statement, "iis", $user_id, $post_id, $comment_text);

    if (mysqli_stmt_execute($statement)) {

        echo "Comment added successfully!";
    } else {
        $_SESSION['errors'][] =  "Server connection failed "; 
        echo '<script>alert("Server connection failed"); window.location="../../404.php";</script>';
        echo "Error: Unable to add comment.";
    }

    mysqli_stmt_close($statement);
} else {
    $_SESSION['errors'][] =  "Server connection failed "; 
    echo '<script>alert("Server connection failed"); window.location="../../404.php";</script>';
    echo "Error: Invalid request method.";
}

// Close the database connection
mysqli_close($connect);
