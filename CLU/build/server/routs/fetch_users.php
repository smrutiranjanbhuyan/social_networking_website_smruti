<?php
include ('../connect.php'); 

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $connect->query($sql);

$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

if($connect->error){
    $_SESSION['errors'][] =  "Server connection failed "; 
    echo '<script>alert("Server connection failed"); window.location="../../404.php";</script>';
}
$connect->close();

// Return users as JSON
echo json_encode($users);
?>
