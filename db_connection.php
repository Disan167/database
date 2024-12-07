<?php
// Database connection parameters
$host = "localhost";  // Change to your database host
$db = "finances";  // Change to your database name
$user = "root";  // Change to your database username
$password = "";  // Change to your database password

// Create connection
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
