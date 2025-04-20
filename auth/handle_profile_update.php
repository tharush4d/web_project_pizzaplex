<?php
session_start();

// --- Authentication Check ---
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    echo "Access Denied. Please login."; // Or redirect
    exit;
}
// --- End Authentication Check ---

$user_id = $_SESSION['user_id'];

// --- Database Connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaplexweb_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
     error_log("Profile Update DB Connection Error: " . $conn->connect_error);
    $_SESSION['profile_message'] = "Database connection error. Please try again later.";
    header('Location: edit_profile.php'); // Redirect back to edit page
    exit;
}
// --- End Database Connection ---


// --- ACTION: Update User Details (Name, Phone, Address) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_details'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address1 = trim($_POST['address1']) ?: null;
    $address2 = trim($_POST['address2']) ?: null;
    $city = trim($_POST['city']) ?: null;

    $errors = [];
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($phone)) $errors[] = "Phone number is required.";
    elseif (!preg_match('/^[0-9]{10}$/', $phone)) $errors[] = "Invalid Phone Number format (10 digits).";
    // Add more validation if needed for address/city

    if (!empty($errors)) {
        $_SESSION['profile_message'] = "Error updating details: <br>" . implode("<br>", $errors);
        header('Location: edit_profile.php');
        exit;
    }

    // Prepare UPDATE statement for details
    $sql = "UPDATE users SET name = ?, phone = ?, address1 = ?, address2 = ?, city = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $phone, $address1, $address2, $city, $user_id);

    if ($stmt->execute()) {
        $_SESSION['profile_message'] = "Profile details updated successfully!";
        // Update session name if it changed
        if ($_SESSION['user_name'] !== $name) {
            $_SESSION['user_name'] = $name;
        }
    } else {
        error_log("Profile Details Update Error: " . $stmt->error);
        $_SESSION['profile_message'] = "Error updating profile details. Please try again.";
    }
    $stmt->close();
    $conn->close();
    header('Location: profile.php'); // Redirect to profile view page
    exit;
}


// --- ACTION: Update Password ---
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    $errors = [];
    if (empty($current_password)) $errors[] = "Current Password is required.";
    if (empty($new_password)) $errors[] = "New Password is required.";
    elseif (strlen($new_password) < 6) $errors[] = "New Password must be at least 6 characters long.";
    if ($new_password !== $confirm_new_password) $errors[] = "New passwords do not match.";

    // If basic validation passes, check current password against DB
    if (empty($errors)) {
        // Fetch current password hash
        $sql_fetch = "SELECT password_hash FROM users WHERE user_id = ?";
        $stmt_fetch = $conn->prepare($sql_fetch);
        $stmt_fetch->bind_param("i", $user_id);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();

        if ($result_fetch->num_rows == 1) {
            $current_hash = $result_fetch->fetch_assoc()['password_hash'];
            // Verify current password
            if (!password_verify($current_password, $current_hash)) {
                $errors[] = "Incorrect Current Password.";
            }
        } else {
            $errors[] = "Could not verify current password (user not found)."; // Should not happen
        }
        $stmt_fetch->close();
    }

    // If errors, redirect back to edit page
    if (!empty($errors)) {
        $_SESSION['profile_message'] = "Error changing password: <br>" . implode("<br>", $errors);
        header('Location: edit_profile.php');
        exit;
    }

    // If everything is okay, hash the new password and update DB
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $sql_update = "UPDATE users SET password_hash = ? WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $new_password_hash, $user_id);

    if ($stmt_update->execute()) {
        $_SESSION['profile_message'] = "Password changed successfully!";
    } else {
        error_log("Password Update Error: " . $stmt_update->error);
        $_SESSION['profile_message'] = "Error changing password. Please try again.";
    }
    $stmt_update->close();
    $conn->close();
    header('Location: profile.php'); // Redirect to profile view page
    exit;
}

// --- No Valid Action ---
else {
    // Redirect if accessed directly or no valid action
    $conn->close();
    header('Location: edit_profile.php');
    exit;
}
?>