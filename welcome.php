<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user information
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $user_name; ?>!</h1>

       <img src="imaage/loook.jpg" alt="welcome image" width="600" height="400">

        <div class="welcome-card">
            <p>You have successfully logged in.</p>
            <p>Your email: <?php echo $user_email; ?></p>
        </div>
       
        <div class="actions">
            <a href="logout.php"><button>Logout</button></a>
            <!-- <a href="index.php"><button>View Products</button></a> -->
        </div>
    </div>
</body>
</html>
