<?php
$servername = "localhost"; // Change if your database is on another server
$username = "root"; // Your database username (default: root for XAMPP)
$password = ""; // Your database password (default: empty for XAMPP)
$database = "esports_db"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
