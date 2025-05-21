<?php
// Include database connection
require_once 'config.php';

try {
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
   
    $pdo->exec($sql);
    echo "Users table created successfully.<br>";
   
    echo "Database setup completed.";
} catch(PDOException $e) {
    die("ERROR: Could not set up database. " . $e->getMessage());
}
?>