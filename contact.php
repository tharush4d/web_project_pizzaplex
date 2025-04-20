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
    <title>Pizza Plex - Contact</title>
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
              <a class="nav-link" href="menu.php">MENU</a>
            </li>
          <li class="nav-item">
            <a class="nav-link" href="services.php">SERVICES</a> 
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">ABOUT</a> 
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="contact.php">CONTACT US</a> 
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

  <!-- Contact Us -->
  <section class="contact-section py-5">
    <div class="container">
      <h1 class="text-center mb-5">📞 Contact Us</h1>
  
      <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0">
           <h3 class="mb-3">📬 Get in Touch</h3>
           <p><i class="fas fa-home fa-fw me-2"></i><strong>Address:</strong> No: 123, Galle Road, Colombo 03
          </p> 
           <p><i class="fas fa-phone fa-fw me-2"></i><strong>Phone:</strong> +94 11 2 345 678
          </p> 
          <p><i class="fas fa-envelope fa-fw me-2"></i><strong>Email:</strong> info@pizzaplex.lk
          </p> 
          <p><i class="fas fa-clock fa-fw me-2"></i><strong>Opening Hours:</strong> 11:00 AM – 11:00 PM (Open 7 days a week)
          </p> 

          <h3 class="mt-4 mb-3">📍 Find Us</h3>
           <div class="map-responsive mb-4">
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.79947985127!2d79.84770084632567!3d6.902210274177006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259631a45075f%3A0x8c0ef59a69585559!2sColombo%2003%2C%20Colombo!5e0!3m2!1sen!2slk!4v1712975555123!5m2!1sen!2slk" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
  
        <div class="col-lg-6">
           <h3 class="mb-3">💬 Send Us a Message</h3>
           <div id="form-status-message" class="mb-3"></div>
           <form action="process_contact.php" method="POST"> 
            <div class="mb-3">
                   <label for="contactName" class="form-label">Name</label>
                   <input type="text" class="form-control" id="contactName" name="contactName" required>
               </div>
               <div class="mb-3">
                   <label for="contactEmail" class="form-label">Email</label>
                   <input type="email" class="form-control" id="contactEmail" name="contactEmail" required>
               </div>
                <div class="mb-3">
                   <label for="contactSubject" class="form-label">Subject</label>
                   <input type="text" class="form-control" id="contactSubject" name="contactSubject">
               </div>
               <div class="mb-3">
                   <label for="contactMessage" class="form-label">Message</label>
                   <textarea class="form-control" id="contactMessage" rows="5" name="contactMessage" required></textarea>
               </div>
               <button type="submit" class="btn btn-primary">Submit</button>

           </form>
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

   <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            // Get the message display area
            const messageDiv = document.getElementById('form-status-message');

            let alertType = '';
            let messageText = '';

            // Determine message based on status
            if (status === 'success') {
                alertType = 'success';
                messageText = 'Thank you! Your message has been successfully received by us.';
            } else if (status === 'dberror' || status === 'connerror') {
                alertType = 'danger';
                messageText = 'Sorry! An error occurred while sending the message. Please try again later.;
            } else if (status === 'invalid') {
                alertType = 'warning';
                messageText = 'Please fill in all the required fields correctly and try again.';
            }

            // If there is a message to display, create and inject the alert
            if (messageText && messageDiv) {
                const alertHTML = `<div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
                                     ${messageText}
                                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                   </div>`;
                messageDiv.innerHTML = alertHTML;


            }
        });
    </script>

</body>
</html>