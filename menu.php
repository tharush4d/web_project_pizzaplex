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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Plex - Menu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
              <a class="nav-link active" href="menu.php">MENU</a>
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

    <!-- hero section -->
  <div class="hero-section-new">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0"> 
          <h1 class="display-4 fw-bold mb-3">Discover Your Perfect Slice!</h1> 
          <p class="lead mb-4">
          From timeless classics to bold new flavors – every pizza is crafted to satisfy. 
          </p>
          <a href="menu.php" class="btn btn-light btn-lg px-4">Order Now</a> 
        </div>
        <div class="col-lg-6 d-flex justify-content-center">
           <img src="images/menu_header.jpg" class="img-fluid hero-pizza-slice" alt="Delicious Pizza Slice"> 
        </div>
      </div>
    </div>
  </div>

    <!-- menu section -->
  <section class="menu-section py-5">
    <div class="container">
      <h1 class="text-center mb-5">🍕 Our Tasty Lineup</h1>
      <div class="row justify-content-center mb-4">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text" id="menu-search-icon">
              <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control" id="menu-search-input" placeholder="Search menu items (e.g., pizza, chicken, garlic)..." aria-label="Search menu items" aria-describedby="menu-search-icon">
          </div>
        </div>
      </div>

      <?php
      // database connection
      $servername = "localhost"; 
      $username = "root";       
      $password = "";           
      $dbname = "pizzaplexweb_db"; 
      $placeholder_image = 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.veryicon.com%2Ficons%2Fmiscellaneous%2Fsimple-linetype-icon%2Ffood-17.html&psig=AOvVaw2zLZgq5sfo-pjqNftUP_mb&ust=1744791970612000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCKj1ueDO2YwDFQAAAAAdAAAAABAE';
      // create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // checking connection
      if ($conn->connect_error) {
          echo "<div class='alert alert-danger text-center'>Database connection failed!!: " . $conn->connect_error . "</div>";
          
      } else {

          $sql = "SELECT id, name, description, image_path, price, category FROM menu_items ORDER BY category, name";
          $result = $conn->query($sql);

          if ($result === FALSE) {
              echo "<div class='alert alert-danger text-center'>Query problem: " . $conn->error . "</div>";
          } elseif ($result->num_rows > 0) {
              $current_category = null; 
              $is_first_category = true; 

              while($row = $result->fetch_assoc()) {
                  
                  if ($current_category !== $row["category"]) {
                      
                      if (!$is_first_category) {
                          echo '</div> ';
                          echo '<hr class="my-5">'; 
                      }

                      $current_category = $row["category"]; 
                      
                      $category_title = ucfirst($current_category);
                      
                      if (!in_array(strtolower($category_title), ['sides'])) { 
                           $category_title .= 's';
                      }

                      echo '<h2 class="mb-4">' . htmlspecialchars($category_title) . '</h2>'; 
                      echo '<div class="row">'; 
                      $is_first_category = false; 
                  }

                  // --- Menu Item showing Bootstrap HTML Structure ---
                  echo '<div class="col-md-6 mb-4 menu-item-card">'; 
                  echo '  <div class="d-flex align-items-center h-100">'; 

                  // Image checking and display
                  $image_path_to_display = $placeholder_image; 
                  if (!empty($row["image_path"]) && file_exists($row["image_path"])) {
                      $image_path_to_display = $row["image_path"]; 
                  }
                  echo '    <img src="' . htmlspecialchars($image_path_to_display) . '" class="img-fluid menu-item-image me-3" alt="' . htmlspecialchars($row["name"]) . '">';

                  // display Item details
                  echo '    <div>';
                  echo '      <h5>' . htmlspecialchars($row["name"]) . '</h5>';
                  
                  if (!empty($row["description"])) {
                      echo '      <p class="text-muted small mb-1">' . htmlspecialchars($row["description"]) . '</p>';
                  }
                  echo '      <p class="fw-bold mb-0">Rs. ' . number_format($row["price"], 2) . '</p>';

                  // --- Add to Cart Form starting ---
      echo '      <form action="cart_handler.php" method="post" class="mt-2">';
      // Item details send by hidden fields 
      echo '          <input type="hidden" name="item_id" value="' . htmlspecialchars($row["id"]) . '">';
      echo '          <input type="hidden" name="item_name" value="' . htmlspecialchars($row["name"]) . '">';
      echo '          <input type="hidden" name="item_price" value="' . htmlspecialchars($row["price"]) . '">';
      
      echo '          <input type="hidden" name="item_quantity" value="1">';
      echo '          <button type="submit" name="add_to_cart" class="btn btn-sm btn-warning">';
      echo '              <i class="fas fa-cart-plus me-1"></i> Add to Cart'; 
      echo '          </button>';
      echo '      </form>';
      // --- Add to Cart Form ending ---

                   
                  echo '    </div>'; 

                  echo '  </div>'; 
                  echo '</div>'; 
                  // --- End Menu Item HTML ---

              } 

              
              if ($current_category !== null) {
                  echo '</div> ';
              }

          } else {
              echo "<div class='alert alert-info text-center'>No adding menu item yet.</div>";
          }

          
          $conn->close();
      } 
      ?>
    </div> 
  </section> 
    
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

    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('menu-search-input');
    // Get all menu item cards using the class we added
    const menuItemCards = document.querySelectorAll('.menu-item-card');
    // Optional: Element to show 'no results' message
    // const noResultsMessage = document.getElementById('no-results-message'); // Create this element if needed

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let itemsFound = 0;

            menuItemCards.forEach(card => {
                // Find the name (h5) and description (p.small) within the card
                const itemNameElement = card.querySelector('h5');
                const itemDescElement = card.querySelector('p.small'); // Select the specific description paragraph

                const itemName = itemNameElement ? itemNameElement.textContent.toLowerCase() : '';
                const itemDesc = itemDescElement ? itemDescElement.textContent.toLowerCase() : '';

                // Check if search term is in name OR description
                const isMatch = (itemName.includes(searchTerm) || itemDesc.includes(searchTerm));

                // Show or hide the card based on match
                if (isMatch) {
                    card.style.display = ''; // Show the card (reset display style)
                    itemsFound++;
                } else {
                    card.style.display = 'none'; // Hide the card
                }
            });

        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const navbarSearchLink = document.getElementById('navbar-search-link');

    if (navbarSearchLink) {
        navbarSearchLink.addEventListener('click', function(event) {
            // Find the menu search input on the CURRENT page
            const menuSearchInput = document.getElementById('menu-search-input');

            if (menuSearchInput) {
                // If the menu search input exists on this page (meaning we are on menu.php)
                event.preventDefault(); // Stop the link from navigating

                // Scroll to the input field smoothly and focus it
                menuSearchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                menuSearchInput.focus();

            } else {
                // If the menu search input doesn't exist on this page,
                // let the link navigate to menu.php (default behavior of the href)
                // Alternatively, you could force navigation here:
                // window.location.href = this.href;
            }
        });
    }
});
</script>

</body>
</html>