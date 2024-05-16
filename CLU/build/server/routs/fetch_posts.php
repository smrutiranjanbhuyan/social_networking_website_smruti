<?php
session_start();
include('../connect.php');

// Initialize posts session variable
$_SESSION['posts'] = [];

// Query to fetch posts
$posts_query = "SELECT * FROM posts";
$posts_result = $connect->query($posts_query);

// Check if posts are found
if ($posts_result->num_rows > 0) {
    $_SESSION['posts'] = $posts_result->fetch_all(MYSQLI_ASSOC);
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Query to get count of users following the current user
$following_query = "SELECT COUNT(*) AS following_count FROM followers WHERE follower_id = $user_id";
$following_result = $connect->query($following_query);
$following_row = $following_result->fetch_assoc();
$following_count = $following_row['following_count'];

// Set following count in session
$_SESSION['following_count'] = $following_count;

// Query to get count of followers for the current user
$followers_query = "SELECT COUNT(*) AS followers_count FROM followers WHERE following_id = $user_id";
$followers_result = $connect->query($followers_query);
$followers_row = $followers_result->fetch_assoc();
$followers_count = $followers_row['followers_count'];

// Set followers count in session
$_SESSION['followers_count'] = $followers_count;

// Query to get count of likes for the current user
$likes_query = "SELECT COUNT(*) AS likes_count FROM likes WHERE user_id = $user_id";
$likes_result = $connect->query($likes_query);
$likes_row = $likes_result->fetch_assoc();
$likes_count = $likes_row['likes_count'];

// Set likes count in session
$_SESSION['likes_count'] = $likes_count;
?>

