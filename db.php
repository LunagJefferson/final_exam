<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "content_website";

$conn = new mysqli('localhost', 'root', '', 'database');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>