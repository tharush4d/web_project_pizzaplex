<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaplexweb_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("User Login DB Connection Error: " . $conn->connect_error);
    $_SESSION['login_error'] = "Database error. Please try again later.";
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password']; // Raw password

    if (empty($email) || empty($password)) {
         $_SESSION['login_error'] = "Email and Password are required.";
         header('Location: login.php');
         exit();
    }

    // Fetch user by email
    $sql = "SELECT user_id, name, email, password_hash FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password_hash'])) {
            // Password is correct, login successful
            // Regenerate session ID for security
            session_regenerate_id(true);

            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name']; // Store name for display
            $_SESSION['user_email'] = $user['email']; // Store email if needed

            // Close connections before redirect
            $stmt->close();
            $conn->close();
            // Redirect to profile page or home page after login
            header('Location: ../index.php'); // Or header('Location: profile.php');
            exit();

        } else {
            // Close connections before redirect
            $stmt->close();
            $conn->close();
            // Invalid password
            $_SESSION['login_error'] = "Invalid email or password.";
            header('Location: login.php');
            exit();
        }
    } else {
        // Close connections before redirect
        $stmt->close();
        $conn->close();
        // User not found
        $_SESSION['login_error'] = "Invalid email or password.";
        header('Location: login.php');
        exit();
    }

} else {
    // Redirect if not POST
    header('Location: login.php');
    exit();
}
?>