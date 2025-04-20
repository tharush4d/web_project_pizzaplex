<?php
session_start();

// Initialize the cart in the session (if it hasn’t been created yet).
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// --- ACTION: Add item to cart ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_quantity = $_POST['item_quantity'];

    if (!empty($item_id) && !empty($item_name) && is_numeric($item_price) && is_numeric($item_quantity) && $item_quantity > 0) {
        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]['quantity'] += $item_quantity;
            $_SESSION['message'] = htmlspecialchars($item_name) . " quantity updated in cart!";
        } else {
            $_SESSION['cart'][$item_id] = array(
                'name' => $item_name,
                'price' => $item_price,
                'quantity' => $item_quantity
            );
            $_SESSION['message'] = htmlspecialchars($item_name) . " added to cart!";
        }
    } else {
         $_SESSION['message'] = "Error: Could not add item to cart. Invalid data.";
    }
    // After adding to the cart, redirecting back to the menu page.
    header('Location: menu.php');
    exit();
}

// --- ACTION: Update cart quantities ---
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
        $updated_count = 0;
        $removed_count = 0;
        foreach ($_POST['quantity'] as $item_id => $quantity) {
            // Checking if the quantity is valid (is it a number, and is it 0 or greater).
            if (isset($_SESSION['cart'][$item_id]) && is_numeric($quantity) && $quantity >= 0) {
                $quantity = intval($quantity); // Converting it to an integer.
                if ($quantity == 0) {
                    // If the quantity is 0, removing the item from the cart.
                    unset($_SESSION['cart'][$item_id]);
                    $removed_count++;
                } else {
                    // If the quantity is greater than 0, updating the item in the cart.
                    $_SESSION['cart'][$item_id]['quantity'] = $quantity;
                    $updated_count++;
                }
            }
        }
        // Creating Message
        $message = "";
        if ($updated_count > 0) $message .= "$updated_count item(s) quantity updated. ";
        if ($removed_count > 0) $message .= "$removed_count item(s) removed from cart.";
        if (empty($message)) $message = "No changes made to the cart.";
         $_SESSION['message'] = $message;

    } else {
        $_SESSION['message'] = "Error: Could not update cart. Invalid data received.";
    }
     // After updating, redirecting to the cart page.
    header('Location: cart.php');
    exit();
}

// --- ACTION: Remove item from cart ---
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
    $item_id_to_remove = $_POST['remove_item_id'];

    if (!empty($item_id_to_remove) && isset($_SESSION['cart'][$item_id_to_remove])) {
        $item_name = $_SESSION['cart'][$item_id_to_remove]['name']; // Getting name for Message
        unset($_SESSION['cart'][$item_id_to_remove]);
        $_SESSION['message'] = htmlspecialchars($item_name) . " removed from cart.";
    } else {
         $_SESSION['message'] = "Error: Could not remove item. Item not found or invalid ID.";
    }
    // After removing, redirecting to the cart page.
    header('Location: cart.php');
    exit();
}

// --- No valid action detected ---
else {
     // By default, redirect to the menu page.
     header('Location: menu.php');
     exit();
}

?>