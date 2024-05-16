<?php

if(!isset($_SESSION)){
    session_start();
}
include('../connect.php');
$_SESSION['errors'] = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $password_pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()-_=+{};:,<.>]).{8,}$/";

    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    if (!preg_match($email_pattern, $username)) {
        echo '<script>alert("Enter a valid email address"); window.location="../../signin.php";</script>';
        exit();
    }

    if (!preg_match($password_pattern, $password)) {
        echo '<script>alert("Enter a valid password (at least 8 characters, including uppercase, lowercase, and digit)"); window.location="../../signin.php";</script>';
        exit();
    }

    $query = "SELECT * FROM users WHERE email ='$username'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password']; 
            
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['avatar'] = $row['profile_pic_url'];
                $session_user_id = $_SESSION['user_id'];

                // Debugging
                echo "User ID: $session_user_id<br>";

                // Query to get user's following count
                $following_query = "SELECT COUNT(*) AS following_count FROM followers WHERE follower_id = $session_user_id";
                $result = $connect->query($following_query);
                $following_row = $result->fetch_assoc();
                $following_count = $following_row['following_count'];
                
                // Debugging
                echo "Following Count: $following_count<br>";
                
                // Query to get user's followers count
                $followers_query = "SELECT COUNT(*) AS followers_count FROM followers WHERE following_id = $session_user_id";
                $result = $connect->query($followers_query);
                $followers_row = $result->fetch_assoc();
                $followers_count = $followers_row['followers_count'];
                
                // Debugging
                echo "Followers Count: $followers_count<br>";
                
                // Query to get user's likes count
                $likes_query = "SELECT COUNT(*) AS likes_count FROM likes WHERE user_id = $session_user_id";
                $result = $connect->query($likes_query);
                $likes_row = $result->fetch_assoc();
                $likes_count = $likes_row['likes_count'];
                
                // Debugging
                echo "Likes Count: $likes_count<br>";

                // Set counts in session
                $_SESSION['following_count'] = $following_count;
                $_SESSION['followers_count'] = $followers_count;
                $_SESSION['likes_count'] = $likes_count;

                // Fetch and set posts in session
                $posts_query = "SELECT * FROM posts";
                $posts_result = $connect->query($posts_query);
                if ($posts_result->num_rows > 0) {
                    $_SESSION['posts'] = $posts_result->fetch_all(MYSQLI_ASSOC);
                } else {
                    $_SESSION['posts'] = [];
                }

                // Debugging
                echo "<pre>";
                print_r($_SESSION);
                echo "</pre>";

                header("Location: ../../dashboard/profile.php");
                exit();
            } else {
                echo '<script>alert("Invalid username or password"); window.location="../../signin.php";</script>';
                exit();
            }
        } else {
            echo '<script>alert("User not found"); window.location="../../signup.php";</script>';
            exit();
        }
    } else {
        $_SESSION['errors'][] =  "Server connection failed "; 
        echo '<script>alert("Server connection failed"); window.location="../../404.php";</script>';
        exit();
    }

    // mysqli_free_result($result);
}

mysqli_close($connect);
?>
