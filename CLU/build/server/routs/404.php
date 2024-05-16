<?php
session_start();

if(isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
    header("Location: ../../404.php");
    exit();
} else {
    header("Location: ../../");
    exit();
}
?>
