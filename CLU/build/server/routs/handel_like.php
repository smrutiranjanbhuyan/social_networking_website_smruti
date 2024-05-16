<?php
session_start(); 
include('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    if (isset($_SESSION['user_id'])) {
        $query = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Like added successfully for post_id: $post_id by user_id: $user_id";
        } else {
            echo "Error: " . mysqli_error($connect);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "User not logged in!";
    }
} else {
    echo "Invalid request method!";
}

mysqli_close($connect);
?>
