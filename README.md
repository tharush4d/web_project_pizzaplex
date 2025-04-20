# web_project_pizzaplex
This is final phase of web project
# Pizza Plex - Online Pizza Ordering System (PHP & MySQL)

Welcome to Pizza Plex! This is a web application developed for ordering pizzas, sides, and drinks online, featuring a customer-friendly interface. Built with PHP, MySQL, css, Bootstrap, and JavaScript.

## Setup and Installation (Local Development)

1.  **Prerequisites:**
    * Local Web Server (XAMPP, WAMP, MAMP) with PHP 8+ & MySQL/MariaDB.
    * Git installed ([git-scm.com](https://git-scm.com/downloads)).
    * Database tool like phpMyAdmin.

2.  **Clone Repository:**
    ```bash
    git clone https://github.com/tharush4d/web_project_pizzaplex/ PizzaPlexWebsite
    cd PizzaPlexWebsite
    ```

3.  **Database Setup:**
    * Start Apache & MySQL from XAMPP Control Panel.
    * Open phpMyAdmin (`http://localhost/phpmyadmin`).
    * Go to the "Import" tab.
    * Choose the `database_schema.sql` file (included in this repository).
    * Click "Go" / "Import" to create all tables.
    

4.  **Configuration:**
    * Navigate to the `includes` folder.
    * Open `db_connect.php`.
    * Verify database credentials (`$servername`, `$username`, `$password`, `$dbname`). Default XAMPP usually uses `root` with an empty password. Ensure `$dbname` is `pizzaplexweb_db`.

5.  **Run Project:**
    * Access the website via your browser: `http://localhost/PizzaPlexWebsite/`

## Features Implemented

**Customer Facing:**
* View Menu Items (Pizza, Sides, Drinks) with categories.
* Live Search functionality on the Menu page.
* Shopping Cart
* User Registration & Login System.
* View & Edit User Profile (Name, Phone, Address, Password).
* View Order History & Specific Order Details.
* Checkout Process with Cash on Delivery option (Pre-fills data for logged-in users).
* Contact Us form to send messages.
* Responsive Design using Bootstrap 5.
* Scroll animations on the homepage (AOS).
* Visual effects on homepage elements.

##  Technologies Used

* **Backend:** PHP 
* **Database:** MySQL 
* **Frontend:** HTML5, CSS3, JavaScript , Bootstrap 5.3
* **Libraries:** Font Awesome 6, AOS (Animate on Scroll)
* **Development Environment:** XAMPP (Apache, MySQL, PHP)
* **Code Organization:** Use of `include` files for header/footer



## Usage

* **Customer Site:** Navigate using the main menu. Browse pizzas, add to cart, register/login, place an order.

---

*Project developed during learning process.*
*[ Tharusha Dilantha | https://github.com/tharush4d/ ]*
