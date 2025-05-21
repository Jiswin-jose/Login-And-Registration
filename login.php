<?php
// Include database connection
require_once 'config.php';

// Initialize variables
$email = "";
$message = "";

// Check for status message from registration
$status = isset($_GET['status']) ? $_GET['status'] : '';
if ($status === 'registered') {
    $message = "Registration successful! Please login.";
    $messageClass = "success-message";
} else {
    $messageClass = "error-message";
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
   
    try {
        // Find user by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
       
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Start session and store user info
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
               
                // Redirect to welcome page
                header("Location: welcome.php");
                exit();
            } else {
                $message = "Invalid password";
            }
        } else {
            $message = "User not found. Please register.";
        }
    } catch(PDOException $e) {
        $message = "ERROR: Could not execute query. " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>User Login</h1>
       
        <?php if(!empty($message)): ?>
            <div class="<?php echo $messageClass; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
       
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
           
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
           
            <div class="form-actions">
                <button type="submit">Login</button>
                <a href="register.php"><button type="button">New User? Register</button></a>
            </div>
        </form>
    </div>
</body>
</html>

