<?php
// Database connection details
$host = 'localhost'; // host 
$username = 'root';  // database username
$password = '';      // database password
$database = 'texteditor_db'; // database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If successful, you can use this connection for queries
?>
