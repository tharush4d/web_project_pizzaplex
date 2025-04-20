<?php
session_start();

$user_details = null;
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    $user_id = $_SESSION['user_id'];

}

// If the cart is empty, redirect to the cart page.
if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    header('Location: cart.php');
    $_SESSION['message'] = "Your cart is empty. Please add items before checking out.";
    exit();
}

// Getting the cart count for the Navbar.
$total_cart_items = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['quantity'])) {
             $total_cart_items += $item['quantity'];
        }
    }
}

// calculate the Order summary for total
$checkout_total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $checkout_total_price += floatval($item['price']) * intval($item['quantity']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Add styles similar to cart.php*/
        .page-content { padding-top: 100px; padding-bottom: 50px; }
        .order-summary { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 30px;}
        
    </style>
</head>
<body>

 <!-- Preloader -->
 <div id="preloader">
      <div class="spinner-border text-danger" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

         <!-- navigation bar -->
 <nav class="navbar navbar-expand-lg navbar-dark navbar-transparent fixed-top">
    <div class="container"> 
      <a class="navbar-brand" href="index.php">
        <img src="images/logo.jpeg" alt="Pizza Plex Logo" height="40" style="border-radius: 50px;"> 
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">HOME</a> 
            </li>
            <li class="nav-item">
              <a class="nav-link" href="menu.php">MENU</a>
            </li>           
          <li class="nav-item">
            <a class="nav-link" href="services.php">SERVICES</a> 
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">ABOUT</a> 
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">CONTACT US</a> 
          </li>

         
            <?php
             // Check if the user is logged in by verifying the session variable
            if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): 
            ?>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user me-1"></i> 

                <?php echo htmlspecialchars($_SESSION['user_name']); ?>

              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                <li><a class="dropdown-item" href="auth/profile.php">My Profile</a></li>
                <li><a class="dropdown-item" href="auth/order_history.php">Order History</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="auth/logout.php">Logout</a></li>
              </ul>
            </li>

         <?php else: ?>

            <li class="nav-item">
                <a class="nav-link" href="auth/login.php">LOGIN</a>
             </li>
             
         <?php endif; ?>

        </ul>

       <div class="d-flex align-items-center ms-lg-3">
        <a href="menu.php#menu-search-input" id="navbar-search-link" class="text-white me-3" title="Search Menu"> 
          <i class="fas fa-search"></i>
        </a>
        <a href="cart.php" class="text-white position-relative"> 
        <i class="fas fa-shopping-cart"></i>

        <?php if ($total_cart_items > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill    bg-danger">
                <?php echo $total_cart_items; ?>
                <span class="visually-hidden">items in cart</span>
            </span>
        <?php endif; ?>
        </a>
       </div>
      </div>
    </div>
  </nav>


   <?php if (isset($_SESSION['message'])): ?>
    <div class="container" style="margin-top: -10px;">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
    <?php
      // session removing after showing Message
      unset($_SESSION['message']);
    ?>
  <?php endif; ?>


     <!-- Checkout -->
  <div class="container page-content">
    <h1 class="text-center mb-5">Checkout</h1>

    <?php if (isset($_SESSION['error_message'])): // error messages that are send by place_order.php ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-7 order-md-1">
        <h4 class="mb-3">Delivery Information</h4>
        <form action="place_order.php" method="post" class="needs-validation" novalidate>

          <div class="mb-3">
            <label for="customer_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo isset($user_details) && is_array($user_details) && isset($user_details['name']) ? htmlspecialchars($user_details['name']) : ''; ?>"
            required>
            <div class="invalid-feedback"> 
              Please enter your full name.               
            </div>
          </div>

          <div class="mb-3">
            <label for="customer_phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" placeholder="e.g., 07xxxxxxxx" value="<?php echo isset($user_details['name']) ? htmlspecialchars($user_details['name']) : ''; ?>" required pattern="[0-9]{10}">
            <div class="invalid-feedback"> Please enter a valid 10-digit phone number.              
            </div>
          </div>

          <div class="mb-3">
            <label for="customer_address1" class="form-label">Address Line 1</label>
            <input type="text" class="form-control" id="customer_address1" name="customer_address1" placeholder="House No, Street Name" value="<?php echo isset($user_details['name']) ? htmlspecialchars($user_details['name']) : ''; ?>" required>
            <div class="invalid-feedback"> Please enter your delivery address.               
            </div>
          </div>

          <div class="mb-3">
            <label for="customer_address2" class="form-label">Address Line 2 
              <span class="text-muted">(Optional)</span></label>
            <input type="text" class="form-control" id="customer_address2" name="customer_address2" placeholder="Apartment, Floor, Landmark etc." value="<?php echo isset($user_details['name']) ? htmlspecialchars($user_details['name']) : ''; ?>">
          </div>

           <div class="mb-3">
            <label for="customer_city" class="form-label">City</label>
            <input type="text" class="form-control" id="customer_city" name="customer_city" value="<?php echo isset($user_details['name']) ? htmlspecialchars($user_details['name']) : ''; ?>" required>
            <div class="invalid-feedback"> Please enter your city. </div>
          </div>

          <hr class="my-4">

          <h4 class="mb-3">Payment Method</h4>
          <div class="alert alert-info">
            <i class="fas fa-money-bill-wave me-2"></i> Cash on Delivery
          </div>
          <hr class="my-4">

          <button class="w-100 btn btn-success btn-lg" type="submit" name="place_order">
            <i class="fas fa-check-circle me-2"></i> Place Order
          </button>
        </form>
      </div>

      <div class="col-md-5 order-md-2">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your Order Summary</span>
          <span class="badge bg-primary rounded-pill"><?php echo $total_cart_items; ?></span>
        </h4>
        <ul class="list-group mb-3">
          <?php foreach ($_SESSION['cart'] as $item_id => $item): ?>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?php echo htmlspecialchars($item['name']); ?></h6>
              <small class="text-muted">Quantity: <?php echo intval($item['quantity']); ?></small>
            </div>
            <span class="text-muted">රු. <?php echo number_format(floatval($item['price']) * intval($item['quantity']), 2); ?></span>
          </li>
          <?php endforeach; ?>

          <li class="list-group-item d-flex justify-content-between bg-light">
            <span class="fw-bold">Total (LKR)</span>
            <strong class="fw-bold">රු. <?php echo number_format($checkout_total_price, 2); ?></strong>
          </li>
        </ul>
         <div class="text-center">
             <a href="cart.php" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit me-1"></i> Edit Cart</a>
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

      <p><a href="index.php" class="footer-link">Home</a></p>
      <p><a href="menu.php" class="footer-link">Menu</a></p>
      <p><a href="about.php" class="footer-link">About Us</a></p>
      <p><a href="contact.php" class="footer-link">Contact Us</a></p>
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
    
    <script src="js/custom.js"></script>
     
    <script>
      /* scrolling animation js */
      AOS.init({
          duration: 800, 
          once: true 
      });
    </script>
    <script>
      // Bootstrap Form Validation Script
      (function () {
        'use strict'
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
          })
      })()
    </script>
</body>
</html>