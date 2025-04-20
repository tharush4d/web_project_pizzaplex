<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaplexweb_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    // In production, log error, don't die directly
    error_log("Registration DB Connection Error: " . $conn->connect_error);
    $_SESSION['register_message'] = "Database connection error. Please try again later.";
    $_SESSION['register_error'] = true;
    header('Location: register.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password']; // Get raw password
    $confirm_password = $_POST['confirm_password'];
    $address1 = trim($_POST['address1']) ?: null; // Set to null if empty
    $address2 = trim($_POST['address2']) ?: null;
    $city = trim($_POST['city']) ?: null;

    $errors = [];

    // Validation
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($phone)) $errors[] = "Phone number is required.";
    elseif (!preg_match('/^[0-9]{10}$/', $phone)) $errors[] = "Invalid Phone Number format (10 digits).";
    if (empty($password)) $errors[] = "Password is required.";
    elseif (strlen($password) < 6) $errors[] = "Password must be at least 6 characters long.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";

    // Check if email already exists
    if (empty($errors)) {
        $sql_check = "SELECT user_id FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $errors[] = "This email address is already registered. Please <a href='login.php'>login</a>.";
        }
        $stmt_check->close();
    }

    // If errors, redirect back
    if (!empty($errors)) {
        $_SESSION['register_message'] = implode("<br>", $errors);
        $_SESSION['register_error'] = true;
        // Optional: Store POST data to re-fill the form (excluding passwords)
        // $_SESSION['register_form_data'] = $_POST;
        header('Location: register.php');
        exit();
    }

    // If no errors, hash password and insert user
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO users (name, email, phone, password_hash, address1, address2, city) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $name, $email, $phone, $password_hash, $address1, $address2, $city);

    if ($stmt_insert->execute()) {
        $stmt_insert->close();
        $conn->close();
        $_SESSION['register_message'] = "Registration successful! You can now login.";
        $_SESSION['register_error'] = false; // Indicate success
        header('Location: login.php'); // Redirect to login page on success
        exit();
    } else {
        $stmt_insert->close();
        $conn->close();
        error_log("Registration Insert Error: " . $stmt_insert->error);
        $_SESSION['register_message'] = "An error occurred during registration. Please try again.";
        $_SESSION['register_error'] = true;
        header('Location: register.php');
        exit();
    }

} else {
    // Redirect if not POST
    header('Location: register.php');
    exit();
}
?>