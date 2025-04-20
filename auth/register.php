<?php
session_start();
//If the user is already logged in, let's send (them) to the profile
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: profile.php');
    exit;
}

// Checking if there are registration errors or a success message.
$message = '';
$alert_type = '';
if (isset($_SESSION['register_message'])) {
    $message = $_SESSION['register_message'];
    $alert_type = isset($_SESSION['register_error']) && $_SESSION['register_error'] ? 'danger' : 'success';
    unset($_SESSION['register_message']);
    unset($_SESSION['register_error']);
}

// Getting the cart count for the Navbar
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
    <title>Register - Pizza Plex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <style>
        
        .page-content { padding-top: 100px; padding-bottom: 50px; }
        .form-container { max-width: 500px; margin: auto; padding: 30px; background-color: #f8f9fa; border-radius: 8px;}
     </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container page-content">
        <div class="form-container">
            <h2 class="text-center mb-4">Create Account</h2>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <form action="handle_register.php" method="post" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                     <div class="invalid-feedback">Please enter your full name.</div>
                </div>
                 <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                     <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10}">
                     <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="6">
                         <div class="invalid-feedback">Password must be at least 6 characters.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                         <div class="invalid-feedback">Passwords do not match.</div>
                    </div>
                </div>
                 <hr>
                 <p class="text-muted small">Optional: You can add a default delivery address now or later from your profile.</p>
                 <div class="mb-3">
                    <label for="address1" class="form-label">Address Line 1</label>
                    <input type="text" class="form-control" id="address1" name="address1">
                 </div>
                  <div class="mb-3">
                    <label for="address2" class="form-label">Address Line 2</label>
                    <input type="text" class="form-control" id="address2" name="address2">
                 </div>
                  <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city">
                 </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
            </form>
            <p class="text-center mt-3">
                Already have an account? <a href="login.php">Login here</a>
            </p>
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
    <script>
        // Bootstrap Form Validation Script
       (function () { 'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
          .forEach(function (form) {
            form.addEventListener('submit', function (event) {
              if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
              }
              form.classList.add('was-validated')
            }, false)
          }) })()

       // Password confirmation validation 
       const password = document.getElementById('password');
       const confirmPassword = document.getElementById('confirm_password');
       confirmPassword.addEventListener('input', () => {
         if (password.value !== confirmPassword.value) {
           confirmPassword.setCustomValidity('Passwords do not match.');
         } else {
           confirmPassword.setCustomValidity('');
         }
       });
       
    </script>
</body>
</html>