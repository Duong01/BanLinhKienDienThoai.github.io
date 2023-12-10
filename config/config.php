<?php
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASS", '');
define("DB_NAME", 'hkt_shop');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $my_db = "hkt_shop";
$conn = new mysqli($servername, $username, $password,$my_db);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
?>
