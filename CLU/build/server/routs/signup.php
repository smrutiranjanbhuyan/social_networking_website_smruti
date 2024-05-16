<?php
session_start();
include('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $password_pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()-_=+{};:,<.>]).{8,}$/";
    $name_pattern = "/^[a-zA-Z\s'-]{3,30}$/";

    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    if (!preg_match($name_pattern, $username)) {
        echo '<script>alert("Enter a valid user name"); window.location="../../signup.php";</script>';
        exit();
    }
    if (!preg_match($email_pattern, $email)) {
        echo '<script>alert("Enter a valid email address"); window.location="../../signup.php";</script>';
        exit();
    }
    if (!preg_match($password_pattern, $password)) {
        echo '<script>alert("Enter a valid password (at least 8 characters, including uppercase, lowercase, and digit)"); window.location="../../signup.php";</script>';
        exit();
    }

    // Check if the username or email already exists
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($connect, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        echo '<script>alert("Username or email already exists"); window.location="../../signup.php";</script>';
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    $insert_result = mysqli_query($connect, $insert_query);

    if ($insert_result) {
        echo '<script>alert("Registration successful! Please login."); window.location="../../signin.php";</script>';
        exit();
    } else {
        // Handle database error
        $_SESSION['errors'][] = "Server connection failed: " . mysqli_error($connect);
        echo '<script>alert("Server connection failed"); window.location="../../404.php";</script>';
        exit();
    }
}

mysqli_close($connect);
?>
