<?php
session_start();
// --- Authentication Check ---
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION['login_error'] = "Please login to edit your profile.";
    header('Location: login.php');
    exit;
}
// --- End Authentication Check ---

$user_id = $_SESSION['user_id'];

// Include DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaplexweb_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current user details
$sql = "SELECT name, email, phone, address1, address2, city FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = null;
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    // Should not happen normally
    session_destroy();
    header('Location: login.php');
    exit;
}
$stmt->close();
$conn->close();

// --- Navbar Variables (If using includes) ---
$total_cart_items = 0; if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) { foreach ($_SESSION['cart'] as $item) { $total_cart_items += $item['quantity'] ?? 0; } }
$user_display_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
// --- End Navbar Variables ---

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Pizza Plex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .page-content { padding-top: 100px; padding-bottom: 50px; }
        /* Add other common styles */
    </style>
</head>
<body>
<!-- include header file -->
    <?php include '../includes/header.php';?>
    <div class="container page-content">
        <h1 class="text-center mb-4">Edit Profile</h1>
        <a href="profile.php" class="btn btn-outline-secondary btn-sm mb-4"><i class="fas fa-arrow-left me-1"></i> Back to Profile</a>

        <?php if (isset($_SESSION['profile_message'])): //showing messages after Update ?>
            <div class="alert alert-<?php echo strpos(strtolower($_SESSION['profile_message']), 'error') !== false ? 'danger' : 'success'; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['profile_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['profile_message']); ?>
        <?php endif; ?>

        <form action="handle_profile_update.php" method="post" class="needs-validation border p-4 rounded bg-light" novalidate>
            <h4>Account Information</h4>
            <hr>
             <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled readonly>
                <small class="form-text text-muted">Email address cannot be changed.</small>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                <div class="invalid-feedback">Please enter your full name.</div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required pattern="[0-9]{10}">
                 <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
            </div>

            <h4 class="mt-4">Default Delivery Address</h4>
            <hr>
            <div class="mb-3">
                <label for="address1" class="form-label">Address Line 1</label>
                <input type="text" class="form-control" id="address1" name="address1" value="<?php echo htmlspecialchars($user['address1'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="address2" class="form-label">Address Line 2</label>
                <input type="text" class="form-control" id="address2" name="address2" value="<?php echo htmlspecialchars($user['address2'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>">
            </div>

            <button type="submit" name="update_details" class="btn btn-primary mt-3">Save Details</button>
        </form>

        <form action="handle_profile_update.php" method="post" class="needs-validation border p-4 rounded bg-light mt-4" novalidate>
             <h4>Change Password</h4>
             <hr>
              <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                <div class="invalid-feedback">Please enter your current password.</div>
            </div>
             <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                 <div class="invalid-feedback">New password must be at least 6 characters.</div>
            </div>
             <div class="mb-3">
                <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                 <div class="invalid-feedback">Passwords do not match.</div>
            </div>
             <button type="submit" name="update_password" class="btn btn-warning mt-3">Change Password</button>
         </form>

    </div>

    <!-- include footer -->
    <?php include '../includes/footer.php';  ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <script>
        // Bootstrap Form Validation Script
       (function () { 'use strict'; var forms = document.querySelectorAll('.needs-validation'); Array.prototype.slice.call(forms).forEach(function (form) { form.addEventListener('submit', function (event) { if (!form.checkValidity()) { event.preventDefault(); event.stopPropagation(); } form.classList.add('was-validated'); }, false); }); })();

       // Password confirmation validation (for new password)
       const newPassword = document.getElementById('new_password');
       const confirmNewPassword = document.getElementById('confirm_new_password');
       if(confirmNewPassword && newPassword) {
           confirmNewPassword.addEventListener('input', () => {
             if (newPassword.value !== confirmNewPassword.value) {
               confirmNewPassword.setCustomValidity('New passwords do not match.');
             } else {
               confirmNewPassword.setCustomValidity('');
             }
           });
        }
    </script>
</body>
</html>