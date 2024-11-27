<?php
// Database connection settings
$host = "sql206.infinityfree.com";          // Usually 'localhost'
$username = "if0_37798701";   // Database username
$password = '210611s014333';   // Database password
$database = "if0_37798701_Student_system";   // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
