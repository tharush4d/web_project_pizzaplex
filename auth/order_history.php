<?php
session_start();
// --- Authentication Check ---
//If the user is not logged in, redirect to the login page.
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION['login_error'] = "Please login to view your order history.";
    header('Location: login.php');
    exit;
}
// --- End Authentication Check ---

$user_id = $_SESSION['user_id']; //get a logged user id

// --- Database Connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzaplexweb_db"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    // Log error and maybe display a friendly message
    error_log("Order History DB Connection Error: " . $conn->connect_error);
    die("Could not connect to the database. Please try again later."); // Simple message for user
}
// --- End Database Connection ---

// --- Fetch User's Orders ---
$orders = []; // Array to hold orders
$sql = "SELECT order_id, order_date, order_total, order_status
        FROM orders
        WHERE user_id = ?
        ORDER BY order_date DESC"; // Sorting to show the newest order first.

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
     die("An error occurred while fetching your orders.");
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row; // Fetch all orders into the array
    }
}
$stmt->close();
$conn->close();
// --- End Fetch User's Orders ---


// gettiing cart count
$total_cart_items = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) { $total_cart_items += $item['quantity'] ?? 0; }
}
// getting logged user name
$user_display_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
// --- End Navbar Variables ---

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order History - Pizza Plex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .page-content { padding-top: 100px; padding-bottom: 50px; }
        th, td { vertical-align: middle; }
    </style>
</head>
<body>

    <?php include '../includes/header.php'; ?>
    <div class="container page-content">
        <h1 class="text-center mb-5">My Order History</h1>

        <?php if (!empty($orders)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th class="text-end">Total (Rs.)</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['order_id']; ?></td>
                                <td><?php echo date('Y-m-d H:i A', strtotime($order['order_date'])); // Format date nicely ?></td>
                                <td class="text-end"><?php echo number_format($order['order_total'], 2); ?></td>
                                <td class="text-center">
                                    <?php
                                        // Display status with a badge (same logic as admin orders)
                                        $status = $order['order_status'];
                                        $badge_class = 'bg-secondary'; // Default
                                        if ($status == 'Pending') $badge_class = 'bg-warning text-dark';
                                        elseif ($status == 'Processing') $badge_class = 'bg-info text-dark';
                                        elseif ($status == 'Completed') $badge_class = 'bg-success';
                                        elseif ($status == 'Cancelled') $badge_class = 'bg-danger';
                                        echo '<span class="badge ' . $badge_class . '">' . htmlspecialchars($status) . '</span>';
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="order_details_customer.php?id=<?php echo $order['order_id']; ?>" class="btn btn-primary btn-sm" title="View Details">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                You have not placed any orders yet.
            </div>
            <div class="text-center">
                <a href="../menu.php" class="btn btn-primary">Start Shopping</a>
            </div>
        <?php endif; ?>

         <div class="text-center mt-4">
             <a href="profile.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Profile</a>
         </div>

    </div>
    <?php include '../includes/footer.php'; ?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   
</body>
</html>