<?php
session_start();

// --- Database connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaplexweb_db"; 

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    // if came Database error redirect checkout 
    $_SESSION['error_message'] = "Database connection failed: " . $conn->connect_error;
    header('Location: checkout.php');
    exit();
}

// --- Order Process Logic ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {

    // 1. Checking if the cart is empty (checking again)
    if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['error_message'] = "Your cart is empty. Cannot place order.";
        header('Location: cart.php');
        exit();
    }

    // 2. get Form Data and Validate 
    $customer_name = trim($_POST['customer_name']);
    $customer_phone = trim($_POST['customer_phone']);
    $customer_address1 = trim($_POST['customer_address1']);
    $customer_address2 = trim($_POST['customer_address2']); // Optional
    $customer_city = trim($_POST['customer_city']);

    $errors = [];
    if (empty($customer_name)) $errors[] = "Full Name is required.";
    if (empty($customer_phone)) $errors[] = "Phone Number is required.";

    // Checking if the phone number has 10 digits. 
    elseif (!preg_match('/^[0-9]{10}$/', $customer_phone)) $errors[] = "Invalid Phone Number format (should be 10 digits).";
    if (empty($customer_address1)) $errors[] = "Address Line 1 is required.";
    if (empty($customer_city)) $errors[] = "City is required.";

    // If there are validation errors, send (the user) back to checkout.
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode("<br>", $errors);
        header('Location: checkout.php');
        exit();
    }

    // 3. Recalculating the Total Amount on the server-side.
    $order_total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $order_total += floatval($item['price']) * intval($item['quantity']);
    }

    // Inside place_order.php, after validation and before DB transaction
$user_id_to_save = null;
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    $user_id_to_save = $_SESSION['user_id'];
}

    // 4. Saving the Order to the Database (within a Transaction).
    $conn->begin_transaction(); // begin Transaction 

    try {
        // Insert into 'orders' table
        $sql_order = "INSERT INTO orders (customer_name, customer_phone, customer_address1, customer_address2, customer_city, order_total, order_status, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_order = $conn->prepare($sql_order);
        $order_status = 'Pending'; // Default status
        $stmt_order->bind_param("sssssdsi", $customer_name, $customer_phone, $customer_address1, $customer_address2, $customer_city, $order_total, $order_status, $user_id_to_save);

        if (!$stmt_order->execute()) {
            throw new Exception("Error inserting order: " . $stmt_order->error);
        }
        $last_order_id = $conn->insert_id; // get new order_id
        $stmt_order->close();

        // Insert into 'order_items' table (loop through cart)
        $sql_items = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price_per_item) VALUES (?, ?, ?, ?, ?)";
        $stmt_items = $conn->prepare($sql_items);

        foreach ($_SESSION['cart'] as $item_id => $item) {
            $product_id = $item_id; // Assuming item_id is the product_id from menu_items
            $product_name = $item['name'];
            $quantity = intval($item['quantity']);
            $price_per_item = floatval($item['price']);

            $stmt_items->bind_param("issid", $last_order_id, $product_id, $product_name, $quantity, $price_per_item);
            if (!$stmt_items->execute()) {
                throw new Exception("Error inserting order item ($product_name): " . $stmt_items->error);
            }
        }
        $stmt_items->close();

        // All successful, commit transaction
        $conn->commit(); 

        // 5. Order is successful: Clearing the cart and redirecting to the Thank You page
        unset($_SESSION['cart']); // unset the Session cart
        $_SESSION['last_order_id'] = $last_order_id; // send the order id to Thank you page

        $conn->close(); // close Database connection
        header('Location: thank_you.php');
        exit();

    } catch (Exception $e) {
        // if has Error, transaction is rollback
        $conn->rollback();

        $_SESSION['error_message'] = "An error occurred while placing your order. Please try again. Error: " . $e->getMessage(); // Detailed error for debugging
        // $_SESSION['error_message'] = "An error occurred while placing your order. Please try again."; // Simpler user message

        $conn->close(); // Database connection close
        header('Location: checkout.php');
        exit();
    }

} else {
    // If it is not a POST request or if the button has not been clicked.
    header('Location: checkout.php'); // redirect Checkout
    exit();
}
?>