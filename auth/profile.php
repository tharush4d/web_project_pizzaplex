<?php
session_start();
// --- Authentication Check ---
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION['login_error'] = "Please login to view your profile.";
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
    die("Connection failed: " . $conn->connect_error); // Basic error handling
}

// Fetch user details
$sql = "SELECT name, email, phone, address1, address2, city, registered_at FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = null;
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    // Should not happen if session is valid, but handle just in case
    session_destroy(); // Log user out if their DB record is missing
    header('Location: login.php');
    exit;
}
$stmt->close();
$conn->close();


// Navbar cart count (Optional if using include)
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
    <title>My Profile - Pizza Plex</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <style>
        .page-content { padding-top: 100px; padding-bottom: 50px; }
        .profile-card { background-color: #f8f9fa; padding: 30px; border-radius: 8px;}
     </style>
</head>
<body>
    <?php include '../includes/header.php';?>
    <div class="container page-content">
        <h1 class="text-center mb-5">My Profile</h1>
        
        <?php if (isset($_SESSION['profile_message'])): ?>
            <div class="alert alert-<?php echo strpos(strtolower($_SESSION['profile_message']), 'error') !== false ? 'danger' : 'success'; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['profile_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['profile_message']); ?>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-card">
                    <h4>Account Details</h4>
                    <hr>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                    <p><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($user['registered_at'])); ?></p>

                    <h4 class="mt-4">Default Address</h4>
                    <hr>
                    <?php if (!empty($user['address1'])): ?>
                        <p><strong>Address Line 1:</strong> <?php echo htmlspecialchars($user['address1']); ?></p>
                        <?php if (!empty($user['address2'])): ?>
                            <p><strong>Address Line 2:</strong> <?php echo htmlspecialchars($user['address2']); ?></p>
                        <?php endif; ?>
                        <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
                    <?php else: ?>
                        <p class="text-muted">You haven't set a default address yet.</p>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="edit_profile.php" class="btn btn-primary me-2">Edit Profile</a> <a href="order_history.php" class="btn btn-secondary">View Order History</a> </div>
                </div>
            </div>
        </div>
    </div>
      <!-- footer section -->
  <footer class="bg-dark text-white pt-5 pb-4"> 
    <div class="container text-center text-md-start"> 
      <div class="row text-center text-md-start">

    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
      <h5 class="text-uppercase mb-4 fw-bold text-warning">Pizza Plex</h5> 
      <p>
        "We’re dedicated to bringing you the best pizza experience in town – made with fresh ingredients and served with exceptional care."
      </p>
    </div>

    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
      <h5 class="text-uppercase mb-4 fw-bold text-warning">Quick Links</h5>

      <p><a href="../index.php" class="footer-link">Home</a></p>
      <p><a href="../menu.php" class="footer-link">Menu</a></p>
      <p><a href="../about.php" class="footer-link">About Us</a></p>
      <p><a href="../contact.php" class="footer-link">Contact Us</a></p>
    </div>

    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
      <h5 class="text-uppercase mb-4 fw-bold text-warning">Contact</h5>

      <p>
        <i class="fas fa-home me-3"></i> No: 123, Galle Road, Colombo 03
      </p> 
      <p>
        <i class="fas fa-envelope me-3"></i> info@pizzaplex.lk
      </p> 
      <p>
        <i class="fas fa-phone me-3"></i> +94 11 2 345 678
      </p>

      <div class="mt-3">
        <a href="https://web.facebook.com" class="footer-link me-3"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com" class="footer-link me-3"><i class="fab fa-instagram"></i></a>
        <a href="https://www.whatsapp.com" class="footer-link"><i class="fab fa-whatsapp"></i></a>
      </div>

  </div> 

    <hr class="mb-4"> 

    <div class="text-center mb-2">
     <p>
       Copyright &copy; <script>document.write(new Date().getFullYear())</script> Pizza Plex. All Rights Reserved.
     </p>
    </div>

</div> 
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="../js/custom.js"></script>
     
    <script>
      /* scrolling animation js */
      AOS.init({
          duration: 800, 
          once: true 
      });
    </script>
</body>
</html>