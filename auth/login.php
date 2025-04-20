<?php
session_start();
// If the user is already logged in, redirect them to the profile page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: profile.php');
    exit;
}

// Checking if there's a login error or a registration success message.
$message = '';
$alert_type = '';
if (isset($_SESSION['login_error'])) {
    $message = $_SESSION['login_error'];
    $alert_type = 'danger';
    unset($_SESSION['login_error']);
} elseif (isset($_SESSION['register_message'])) { // Check for registration success message
    $message = $_SESSION['register_message'];
    $alert_type = 'success';
    unset($_SESSION['register_message']);
}

//Getting the cart count to display on the navbar
$total_cart_items = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) { $total_cart_items += $item['quantity'] ?? 0; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pizza Plex</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <style>
        /* Add custom styles */
        .page-content { padding-top: 100px; padding-bottom: 50px; }
        .form-container { max-width: 450px; margin: auto; padding: 30px; background-color: #f8f9fa; border-radius: 8px;}
     </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container page-content">
        <div class="form-container">
            <h2 class="text-center mb-4">Customer Login</h2>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <form action="handle_user_login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
             <p class="text-center mt-3">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
             
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>