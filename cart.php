<?php
session_start(); 
// calculate all item quantity in tha cart
$total_cart_items = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['quantity'])) {
             $total_cart_items += $item['quantity'];
        }
    }
}


// Initializing the total amount in the cart.
$cart_total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart-Pizza Plex</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .page-content {
            padding-top: 100px; 
            padding-bottom: 50px; 
        }
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
        }
        .quantity-input {
            width: 60px; /* Quantity input field size */
        }
        .table th, .table td {
            vertical-align: middle; /* Table content vertically align */
        }
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
              <a class="nav-link active" href="cart.php">CART</a> 
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

<!--  Shopping Cart -->
  <div class="container page-content">
    <h1 class="text-center mb-5">Your Shopping Cart</h1>

    <?php if (isset($_SESSION['message'])): // showing messages by Cart handler ?>
      <div class="alert alert-<?php echo strpos(strtolower($_SESSION['message']), 'error') !== false ? 'danger' : 'success'; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['message']); // Removing the message after showing it. ?>
    <?php endif; ?>


    <?php
    // Checking if the cart is empty.
    if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) :
    ?>
        <div class="alert alert-info text-center">
            Your shopping cart is currently empty.
        </div>
        <div class="text-center">
            <a href="menu.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    <?php
    // If there are items in the cart.
    else :
    ?>
        <form action="cart_handler.php" method="post">
            <div class="table-responsive"> 
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Looping through the items in the cart.
                        foreach ($_SESSION['cart'] as $item_id => $item) :
                            // Getting Item details
                            $item_name = htmlspecialchars($item['name']);
                            $item_price = floatval($item['price']); // Getting like a number
                            $item_quantity = intval($item['quantity']); // Getting like a number
                            $item_subtotal = $item_price * $item_quantity;
                            $cart_total_price += $item_subtotal;
                        ?>
                            <tr>
                                <td><?php echo $item_name; ?></td>
                                <td class="text-end">Rs. <?php echo number_format($item_price, 2); ?></td>
                                <td class="text-center">
                                    <input type="number" name="quantity[<?php echo $item_id; ?>]" value="<?php echo $item_quantity; ?>" min="0" class="form-control form-control-sm quantity-input d-inline-block">
                                </td>
                                <td class="text-end">Rs. <?php echo number_format($item_subtotal, 2); ?></td>
                                <td class="text-center">
                                    <form action="cart_handler.php" method="post" style="display: inline;">
                                        <input type="hidden" name="remove_item_id" value="<?php echo $item_id; ?>">
                                        <button type="submit" name="remove_from_cart" class="btn btn-danger btn-sm" title="Remove Item">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        endforeach; // End of cart items loop
                        ?>
                    </tbody>
                </table>
            </div> 
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                <div>
                    <a href="menu.php" class="btn btn-outline-secondary mb-2"><i class="fas fa-arrow-left me-1"></i> Continue Shopping</a>
                    <button type="submit" name="update_cart" class="btn btn-info mb-2"><i class="fas fa-sync-alt me-1"></i> Update Cart</button>
                </div>
                <div class="text-end">
                    <h4>Total: Rs. <?php echo number_format($cart_total_price, 2); ?></h4>
                    <a href="checkout.php" class="btn btn-success btn-lg mt-2">Proceed to Checkout <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </form> <?php
    endif; // End if cart is not empty
    ?>

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
    
    <script src="js/custom.js"></script>
     
    <script>
      /* scrolling animation js */
      AOS.init({
          duration: 800, 
          once: true 
      });
    </script>
</body>
</html>