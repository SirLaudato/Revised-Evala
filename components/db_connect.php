<?php
session_start();
// Redirect if already logged in
if ($_SESSION['role'] != "IAB") {
    header("Location: ../pages/login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "evala_db1";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>