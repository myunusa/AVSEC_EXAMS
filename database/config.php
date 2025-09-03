<?php
// Database connection settings
$host = "localhost";      // usually localhost in XAMPP
$user = "root";           // default user in XAMPP
$pass = "";               // default password is empty in XAMPP
$dbname = "avsec_exams";        // your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
