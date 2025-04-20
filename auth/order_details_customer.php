<?php
session_start();
// --- Authentication Check ---
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION['login_error'] = "Please login to view order details.";
    header('Location: login.php');
    exit;
}
// --- End Authentication Check ---

// --- Get Order ID from URL and Validate ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect if ID is missing or invalid
    // Optional: Set a message for order_history page
    $_SESSION['order_history_message'] = ['text' => 'Invalid Order ID specified.', 'type' => 'danger'];
    header('Location: order_history.php');
    exit;
}
$order_id = intval($_GET['id']);
$user_id = $_SESSION['user_id']; // Get logged-in user's ID
// --- End Get Order ID ---

// --- Database Connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaplexweb_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("Order Details Customer DB Connection Error: " . $conn->connect_error);
    die("Database connection error. Please try again later.");
}
// --- End Database Connection ---

// --- Fetch Order Details (Authorization Check Included) ---
$order = null;
$sql_order = "SELECT * FROM orders WHERE order_id = ? AND user_id = ?"; // Check BOTH order_id AND user_id
$stmt_order = $conn->prepare($sql_order);
if ($stmt_order === false) {
     error_log("Prepare failed (order): (" . $conn->errno . ") " . $conn->error);
     die("An error occurred while fetching your order details.");
}
$stmt_order->bind_param("ii", $order_id, $user_id); // Bind both parameters
$stmt_order->execute();
$result_order = $stmt_order->get_result();

if ($result_order->num_rows == 1) {
    $order = $result_order->fetch_assoc();
} else {
    // Order not found OR order does not belong to this user - Redirect
    $_SESSION['order_history_message'] = ['text' => 'Order not found or you do not have permission to view it.', 'type' => 'danger'];
    $stmt_order->close();
    $conn->close();
    header('Location: order_history.php');
    exit;
}
$stmt_order->close();
// --- End Fetch Order Details ---

// --- Fetch Order Items ---
$order_items = [];
$sql_items = "SELECT product_name, quantity, price_per_item FROM order_items WHERE order_id = ?";
$stmt_items = $conn->prepare($sql_items);
if ($stmt_items === false) {
    error_log("Prepare failed (items): (" . $conn->errno . ") " . $conn->error);
    // Don't necessarily die, maybe just show an error for the items section
} else {
    $stmt_items->bind_param("i", $order_id);
    $stmt_items->execute();
    $result_items = $stmt_items->get_result();
    if ($result_items->num_rows > 0) {
        while($item = $result_items->fetch_assoc()) {
            $order_items[] = $item;
        }
    }
    $stmt_items->close();
}
$conn->close(); // Close connection after all fetching is done
// --- End Fetch Order Items ---


// --- Navbar Variables (If using includes) ---
$total_cart_items = 0; // Cart count (might be 0 if order was just placed)
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) { $total_cart_items += $item['quantity'] ?? 0; }
}
$user_display_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
// --- End Navbar Variables ---

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details #<?php echo $order['order_id']; ?> - Pizza Plex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>      
        .order-details-card { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;}
        th, td { vertical-align: middle; }
    </style>
</head>
<body>

    <?php include '../includes/header.php';?>
    <div class="container page-content">
        <h1 class="mb-4">Order Details <span class="text-primary">#<?php echo $order['order_id']; ?></span></h1>
        <a href="order_history.php" class="btn btn-outline-secondary btn-sm mb-4"><i class="fas fa-arrow-left me-1"></i> Back to Order History</a>

        <div class="row">
            <div class="col-md-6">
                <div class="order-details-card">
                    <h4>Order Summary</h4>
                    <hr>
                    <p><strong>Order Date:</strong> <?php echo date('Y-m-d H:i A', strtotime($order['order_date'])); ?></p>
                    <p><strong>Status:</strong>
                        <?php
                            // Display status with badge
                            $status = $order['order_status'];
                            $badge_class = 'bg-secondary'; // Default
                            if ($status == 'Pending') $badge_class = 'bg-warning text-dark';
                            elseif ($status == 'Processing') $badge_class = 'bg-info text-dark';
                            elseif ($status == 'Completed') $badge_class = 'bg-success';
                            elseif ($status == 'Cancelled') $badge_class = 'bg-danger';
                            echo '<span class="badge ' . $badge_class . '">' . htmlspecialchars($status) . '</span>';
                        ?>
                    </p>
                     <p><strong>Total Amount:</strong> <strong class="text-danger">Rs. <?php echo number_format($order['order_total'], 2); ?></strong></p>
                </div>
            </div>
            <div class="col-md-6">
                 <div class="order-details-card">
                    <h4>Delivery Address</h4>
                    <hr>
                     <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                     <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                     <p><?php echo htmlspecialchars($order['customer_address1']); ?></p>
                     <?php if (!empty($order['customer_address2'])): ?>
                         <p><?php echo htmlspecialchars($order['customer_address2']); ?></p>
                     <?php endif; ?>
                     <p><?php echo htmlspecialchars($order['customer_city']); ?></p>
                 </div>
            </div>
        </div>


        <h4 class="mt-4">Items Ordered</h4>
        <?php if (!empty($order_items)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Item Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Price per Item (Rs.)</th>
                            <th class="text-end">Subtotal (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item):
                             $subtotal = floatval($item['price_per_item']) * intval($item['quantity']);
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td class="text-center"><?php echo intval($item['quantity']); ?></td>
                                <td class="text-end"><?php echo number_format(floatval($item['price_per_item']), 2); ?></td>
                                <td class="text-end"><?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                         <tr class="table-light fw-bold">
                             <td colspan="3" class="text-end">Grand Total</td>
                             <td class="text-end">Rs. <?php echo number_format($order['order_total'], 2); ?></td>
                         </tr>
                     </tfoot>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Could not retrieve items for this order.</div>
        <?php endif; ?>

    </div>
    <?php include '../includes/footer.php';  ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>