<?php
session_start();
if ($_SESSION['role'] != 'IAB') {
    session_destroy();
    header('Location: /Revised-Evala/pages/login.php');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evala_db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $status = $_POST['status'];

    // Update the user's active status in the database
    $stmt = $conn->prepare("UPDATE `users` SET `active_flag` = ? WHERE `user_id` = ?");
    $stmt->bind_param("ii", $status, $userId);

    if ($stmt->execute()) {
        echo "User status updated successfully.";
    } else {
        echo "Failed to update user status.";
    }

    $stmt->close();
}

$conn->close();
?>