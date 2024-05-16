<?php
  $server = "localhost";
  $user = "root";
  $db_password = ""; 
  $database = "social_network_db";
  $connect= mysqli_connect($server, $user, $db_password, $database) or die ( '<script>alert("Server connection failed"); window.location="../../404.php";</script>');

?>