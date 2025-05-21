<?php
// Enable error reporting for debugging (can be removed in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database Configuration
$db_host = 'localhost';
$db_name = 'jswn';  // Your database name
$db_user = 'root';       // Default WAMP username
$db_pass = '';           // Default WAMP password (blank)

// Connection
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect to database. " . $e->getMessage());
}

// Function to sanitize input data
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
