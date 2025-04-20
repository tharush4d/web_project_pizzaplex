<?php


//getting cart count
$total_cart_items = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) { $total_cart_items += $item['quantity'] ?? 0; }
}

// getting loged user name(optional)
$user_display_name = null;
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true && isset($_SESSION['user_name'])) {
    $user_display_name = $_SESSION['user_name'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        
         .page-content { padding-top: 100px; padding-bottom: 50px; }
         .navbar-scrolled { background-color: rgba(0, 0, 0, 0.8); transition: background-color 0.3s ease-in-out; }
         .navbar-transparent { background-color: transparent; transition: background-color 0.3s ease-in-out; }
         .footer-link { color: #adb5bd; text-decoration: none; transition: color 0.3s ease; }
         .footer-link:hover { color: #ffffff; }
    </style>
    </head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-transparent fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../index.php"> 
            <img src="../images/logo.jpeg" alt="Pizza Plex Logo" height="40" style="border-radius: 50px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="../index.php">HOME</a></li> <li class="nav-item"><a class="nav-link" href="../menu.php">MENU</a></li>
                
                <li class="nav-item"><a class="nav-link" href="../services.php">SERVICES</a></li>
                <li class="nav-item"><a class="nav-link" href="../about.php">ABOUT</a></li>
                <li class="nav-item"><a class="nav-link" href="../contact.php">CONTACT US</a></li>

                <?php if ($user_display_name): ?>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i> 
                        <?php echo htmlspecialchars($user_display_name); ?>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                        <li><a class="dropdown-item" href="order_history.php">Order History</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                      </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">LOGIN</a>
                     </li>
                    
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center ms-lg-3">
        <a href="../menu.php#menu-search-input" id="navbar-search-link" class="text-white me-3" title="Search Menu"> 
          <i class="fas fa-search"></i>
        </a>
        <a href="../cart.php" class="text-white position-relative"> 
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