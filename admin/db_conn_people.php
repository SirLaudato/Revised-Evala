<?php
// Database configuration
$servername = "localhost";  // Database host 
$username = "root";         // database username 
$password = "";             // database password 
$dbname = "people";  // Name of database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // If connection fails, display error message and terminate script
    die("Connection failed: " . $conn->connect_error);
}
?>