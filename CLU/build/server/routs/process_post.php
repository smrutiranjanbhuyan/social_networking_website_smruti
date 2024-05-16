<?php
include('../connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postType = $_POST['postType'];
    $postTitle = mysqli_real_escape_string($connect, $_POST['postTitle']);
    $postDescription = mysqli_real_escape_string($connect, $_POST['postDescription']);
    $user_id = $_SESSION['user_id']; 

    $targetDirectory = "../../uploads/";
    $targetFile = $targetDirectory . basename($_FILES["postImage"]["name"]);

    if (move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFile)) {
        $query = "INSERT INTO posts (user_id, post_type, title, post_image, created_at, content) VALUES (?, ?, ?, ?, NOW(), ?)";
        $stmt = mysqli_prepare($connect, $query);
        
        if ($stmt) {
            $targetFile = preg_replace('/\.\.\/\.\.\/uploads\//', '', $targetFile);
            mysqli_stmt_bind_param($stmt, "issss", $user_id, $postType, $postTitle, $targetFile, $postDescription);
            
            if (mysqli_stmt_execute($stmt)) {
                
                echo "<script>alert('Post added successfully!');</script>";
                header("Location: ../../../dashboard/posts.php");
            } else {
                echo `<script>alert('Something went wrong');</script>`;
               
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    } else {
   
        echo "<script>alert('Sorry, there was an error uploading your file!');</script>";
        header("Location: ../../404.php");
    }

    mysqli_close($connect);
}
?>
