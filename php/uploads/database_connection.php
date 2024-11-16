<?php
// Database connection settings
$host = 'localhost'; // Change this to your database host (e.g., 'localhost', IP address)
$db_user = 'root';   // Your database username
$db_pass = '';       // Your database password
$db_name = 'Cara'; // The name of your database

// Create a connection
$con = mysqli_connect($host, $db_user, $db_pass, $db_name);

// Check connection
if (mysqli_connect_errno()) {
    // If the connection fails, output an error message and exit
    die("Connection failed: " . mysqli_connect_error());
}

// Set the character set to UTF-8 (optional but recommended for handling special characters)
mysqli_set_charset($con, 'utf8');
?>
