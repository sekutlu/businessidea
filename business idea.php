<?php
$servername = "localhost";
$username = "root";   // your MySQL username
$password = "";       // your MySQL password (empty on XAMPP)
$dbname = "business idea";     // CHANGE to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
