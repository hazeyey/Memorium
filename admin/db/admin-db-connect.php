<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";  
$username = "root";   
$password = "";       
$database = "cemetery_db"; 

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
