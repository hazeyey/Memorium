<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";  // Change if needed
$username = "root";   // Change this to your database username
$password = "";       // Change this to your database password
$database = "cemetery_db"; // Change this to your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
