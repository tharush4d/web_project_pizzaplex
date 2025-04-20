<?php


$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "pizzaplexweb_db"; 

// Create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error - Don't show detailed errors to users in a live site
    error_log("Database Connection Error: (" . $conn->connect_errno . ") " . $conn->connect_error);
    // Stop execution and show a generic error
    die("Database connection failed. Please check configuration or contact support.");
}

// Set character set to utf8mb4 (Recommended for better character support)
if (!$conn->set_charset("utf8mb4")) {
     error_log("Error loading character set utf8mb4: " . $conn->error);
     // Optional: die() or proceed with caution
}



?>