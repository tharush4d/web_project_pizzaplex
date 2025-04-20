<?php
session_start();

// Unset all of the user session variables
unset($_SESSION['user_logged_in']);
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);



// Redirect to homepage
header('Location: ../index.php');
exit();
?>