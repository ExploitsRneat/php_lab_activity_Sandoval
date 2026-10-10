<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "php_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
    }
echo "Connected Succesfully";
?>
