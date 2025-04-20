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
    <title>Pizza Plex - Home</title>
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
              <a class="nav-link active" aria-current="page" href="index.php">HOME</a> 
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

      <!-- hero section -->
  <div class="hero-section-new">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0"> 
          <h1 class="display-4 fw-bold mb-3">
            Welcome to Pizza Plex – Where Sri Lanka’s Best Pizza Awaits!
          </h1> 
          <p class="lead mb-4">
          Indulge in the ultimate pizza experience at Pizza Plex! We serve up mouthwatering pizzas made with the freshest ingredients, priced just right, and delivered with warm, friendly service. Whether you're a classic Margherita lover or a fan of bold, loaded flavors – your perfect slice is here. 
         </p>
          <a href="menu.php" class="btn btn-light btn-lg px-4">Order Now</a> 
        </div>
        <div class="col-lg-6 d-flex justify-content-center">
           <img src="images/pizza-slice.png" class="img-fluid hero-pizza-slice" alt="Delicious Pizza Slice"> 
        </div>
      </div>
    </div>
  </div>

      <!-- about section -->
  <div class="container mt-4 py-5"> 
    <div class="row align-items-center"> 
      <div class="col-md-6" data-aos="fade-right"> 
        <h2>About Pizza Plex</h2>
          <p>
             At Pizza Plex, we believe that great pizza brings people together. That’s why we’re dedicated to serving up a wide selection of freshly baked pizzas, made with only the highest quality ingredients. From timeless classics like Margherita to bold flavors like spicy pepperoni and our signature gourmet creations, every bite is a celebration of taste and tradition.
          </p>
          <p>
            We prepare our pizzas fresh every time using only the highest quality ingredients. We offer a variety of flavors to suit your unique taste.
            Come to Pizza Plex today – and make the best pizza experience your own!
          </p>
          <a href="menu.php" class="btn btn-primary">View Menu</a> 
      </div>
      <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
      <img src="images/welcome_1.jpg" class="img-fluid rounded" alt="Delicious Pizza from Pizza Plex">
      </div>
    </div>
  </div>

  <!-- featured-pizzas -->
  <section class="featured-pizzas-carousel py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-4" data-aos="fade-up">
        🍕 The Tastiest Delight – Our Most Popular Pizza!
      </h2>

    <div id="featuredPizzaCarousel" class="carousel slide carousel-dark " data-bs-ride="carousel" data-aos="fade-up" data-aos-delay="100">
      <div class="carousel-inner">

        <div class="carousel-item active"> 
          <div class="row">

            <div class="col-md-4 mb-4"> 
              <div class="card h-100">
                <img src="images/Pepperoni_Pizza.jpg" class="card-img-top" alt="Pepperoni Pizza"> <div class="card-body d-flex flex-column">
                  <h5 class="card-title">🍕 Pepperoni Pizza</h5> 
                  <p class="card-text">
                    The classic pepperoni flavor, loaded with hot, gooey mozzarella cheese...
                  </p> 
                  <p class="fw-bold mt-auto">From Rs. 1800</p> 
                  <a href="menu.php" class="btn btn-primary">Order Now</a>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-4 d-none d-md-block"> 
              <div class="card h-100">
                <img src="images/Chicken_BBQ_Pizza.jpg" class="card-img-top" alt="Chicken BBQ Pizza"> 
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">🔥 Chicken BBQ Pizza</h5> 
                  <p class="card-text">
                    Juicy chunks of chicken in rich, smoky BBQ sauce....
                  </p> 
                  <p class="fw-bold mt-auto">From Rs. 1950</p> 
                  <a href="menu.php" class="btn btn-primary">Order Now</a>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-4 d-none d-md-block"> 
              <div class="card h-100">
                 <img src="images/Margherita_Pizza.jpg" class="card-img-top" alt="Margherita Pizza"> <div class="card-body d-flex flex-column">
                  <h5 class="card-title">🌿 Margherita Pizza</h5> 
                  <p class="card-text">
                    Simplicity at its finest – tomato sauce and fresh mozzarella...
                  </p> 
                  <p class="fw-bold mt-auto">From Rs. 1500</p> 
                  <a href="menu.php" class="btn btn-primary">Order Now</a>
                </div>
              </div>
            </div>
          </div> 
        </div> 
        
        <div class="carousel-item">
           <div class="row">

             <div class="col-md-4 mb-4">
              <div class="card h-100">
                <img src="images/Hawaiian_izza.jpg" class="card-img-top" alt="Hawaiian Pizza"> 
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">🍍 Hawaiian Pizza</h5> 
                  <p class="card-text">
                    A tropical twist with ham and pineapple pieces, topped with mozzarella cheese..
                  </p> 
                  <p class="fw-bold mt-auto">From Rs. 1850</p> 
                  <a href="menu.php" class="btn btn-primary">Order Now</a>
                </div>
              </div>
            </div>

             <div class="col-md-4 mb-4 d-none d-md-block">
              <div class="card h-100">
                <img src="images/Vegetarian_Pizza.jpg" class="card-img-top" alt="Vegetarian Pizza"> <div class="card-body d-flex flex-column">
                  <h5 class="card-title">🥗 Vegetarian Pizza</h5> 
                  <p class="card-text">
                    A garden-fresh mix of bell peppers, onions, olives, and more...
                  </p> 
                  <p class="fw-bold mt-auto">From Rs. 1700</p> 
                  <a href="menu.php" class="btn btn-primary">Order Now</a>
                </div>
              </div>
            </div>

             <div class="col-md-4 mb-4 d-none d-md-block">
               <div class="card h-100">
                <img src="images/Seafood_Delight.jpg" class="card-img-top" alt="Seafood Delight Pizza"> 
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">🌊 Seafood Delight</h5> 
                  <p class="card-text">
                    A seafood lover’s dream – prawns, cuttlefish, fish chunks, and creamy white sauce...
                  </p> 
                  <p class="fw-bold mt-auto">From Rs. 2200</p> 
                  <a href="menu.php" class="btn btn-primary">Order Now</a>
                </div>
              </div>
            </div>

           </div> 
          </div>
         </div> 

       </div> 
      </div> 
  </section>

         <!-- Testimonials Section -->
  <section class="testimonials py-5 bg-light">
    <div class="container">
      <div class="section-header text-center mb-5" data-aos="fade-up">
        <h2 class="section-title">What Our Customers Say</h2>
        <p class="section-subtitle">Don't just take our word for it</p>
      </div>

      <div class="testimonial-slider" data-aos="fade-up" data-aos-delay="200">
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">

            <div class="carousel-item active">
              <div class="testimonial-card">
                <div class="rating">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                  "The best pizza I've had in Colombo! Fresh ingredients, perfect crust, and amazing flavors. The delivery was quick too!"
                </p>
                <div class="testimonial-author">
                  <img src="images/custormer_1.jpg" alt="Customer Photo" class="author-image">
                  <div>
                    <h5 class="author-name">Samantha Perera</h5>
                    <p class="author-location">Colombo</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="testimonial-card">
                <div class="rating">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="testimonial-text">
                  "The Seafood Delight pizza is absolutely incredible! Worth every rupee. Pizza Plex never disappoints with their quality."
                </p>
                <div class="testimonial-author">
                  <img src="images/custormer_2.jpg" alt="Customer Photo" class="author-image">
                  <div>
                    <h5 class="author-name">Rajiv Mendis</h5>
                    <p class="author-location">Negombo</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="carousel-item">
              <div class="testimonial-card">
                <div class="rating">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                  "Family pizza night is always Pizza Plex night! The kids love the Hawaiian pizza, and I'm obsessed with their BBQ Chicken. Great service too!"
                </p>
                <div class="testimonial-author">
                  <img src="images/custormer_3.jpg" alt="Customer Photo" class="author-image">
                  <div>
                    <h5 class="author-name">Priya Fernando</h5>
                    <p class="author-location">Kandy</p>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
            <span class="visually-hidden">Previous</span>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
            <span class="visually-hidden">Next</span>
          </button>

        </div>
      </div>
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
</body>
</html>