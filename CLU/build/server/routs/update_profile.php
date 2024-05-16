<?php
session_start(); // Start the session
include('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = isset($_SESSION["username"]) ? $_SESSION["username"] : "User" . mt_rand(1000, 9999);

    // Retrieve user ID from session
    $userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";

    // Assuming phone number is still being submitted via form input
    $phone = !empty($_POST["inputPhone"]) ? $_POST["inputPhone"] : "";

    if (!empty($_FILES["inputProfilePicture"]["name"])) {
        $targetDirectory = "../../uploads/";
        $filename = basename($_FILES["inputProfilePicture"]["name"]);
        $targetFile = $targetDirectory . $filename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["inputProfilePicture"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if ($_FILES["inputProfilePicture"]["size"] > 500000) {
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "<script>alert('Sorry, there was an error uploading your file!');</script>";
            header("Location: ../../404.php");
        } else {
            if (move_uploaded_file($_FILES["inputProfilePicture"]["tmp_name"], $targetFile)) {
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file!');</script>";
                header("Location: ../../404.php");
            }
        }
    } else {
        $targetFile = "";
    }

    // Remove "../../uploads/" using regex
    $targetFile = preg_replace('/\.\.\/\.\.\/uploads\//', '', $targetFile);

    $sql = "UPDATE users SET phone=?, profile_pic_url=? WHERE user_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssi", $phone, $targetFile, $userId);

    if ($stmt->execute()) {
        $_SESSION['avatar']=$targetFile;
     
        header("Location: ../../dashboard/profile.php");
        exit();
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file!');</script>";
        header("Location: ../../404.php");
    }

    $stmt->close();
    $connect->close();
}
?>
