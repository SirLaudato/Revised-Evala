<?php
session_start();
if ($_SESSION['role'] != 'IAB') {
    session_destroy();
    header('Location: /Revised-Evala/pages/login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evala_db1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $newPassword = $_POST['new_password']; // The prehashed password value

    // Update password in the database
    $stmt = $conn->prepare("UPDATE `users` SET `password` = ? WHERE `user_id` = ?");
    $stmt->bind_param("si", $newPassword, $userId);

    if ($stmt->execute()) {
        echo "<script>alert('Password reset successful'); window.location.href = 'students.php';</script>";
    } else {
        echo "<script>alert('Password reset failed'); window.location.href = 'students.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>