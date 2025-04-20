<?php
// Database Connection Variables
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "pizzaplexweb_db";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["contactName"]));
    $email = htmlspecialchars(trim($_POST["contactEmail"]));
    $subject = htmlspecialchars(trim($_POST["contactSubject"]));
    $message = htmlspecialchars(trim($_POST["contactMessage"]));

    // Basic Validation
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $dsn = "mysql:host=" . $dbHost . ";dbname=" . $dbName . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, $dbUser, $dbPass, $options);

           
            $sql = "INSERT INTO contact_messages (name, email, subject, message, status) VALUES (:name, :email, :subject, :message, :status)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);
            $status = 'unread'; // Set default status
            $stmt->bindParam(':status', $status);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // !!! Success -> Redirect to contact page with success status !!!
                header("Location: contact.php?status=success");
                exit; 
            } else {
                // !!! DB Execute Error -> Redirect with error status !!!
                header("Location: contact.php?status=dberror");
                exit;
            }

        } catch (PDOException $e) {
            // Log the error for admin (don't show specific error to user)
            error_log("Database Error: " . $e->getMessage());
            // !!! DB Connection Error -> Redirect with generic error status !!!
            header("Location: contact.php?status=connerror");
            exit;
        } finally {
            $pdo = null;
            $stmt = null;
        }
    } else {
        // !!! Invalid input -> Redirect with validation error status !!!
        header("Location: contact.php?status=invalid");
        exit;
    }
} else {
    // If not a POST request, redirect to homepage
    header("Location: index.php");
    exit;
}
?>