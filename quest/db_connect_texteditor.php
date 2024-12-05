<?php
// Database connection details
$host = 'localhost'; // Change to your host (e.g., 127.0.0.1)
$username = 'root';  // Change to your database username
$password = '';      // Change to your database password
$database = 'texteditor_db'; // Change to your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If successful, you can use this connection for queries
?>
