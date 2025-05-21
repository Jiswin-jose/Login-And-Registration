<?php
// Include database connection
require_once 'config.php';

// Initialize variables for form
$name = $email = $phone = "";
$message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = $_POST['password']; // Will be hashed
   
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format";
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
           
            if ($stmt->rowCount() > 0) {
                $message = "Email already registered. Please login instead.";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
               
                // Prepare SQL and bind parameters
                $sql = "INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)";
                $stmt = $pdo->prepare($sql);
               
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':password', $hashed_password);
               
                // Execute statement and redirect
                if ($stmt->execute()) {
                    // Redirect to login page with success message
                    header("Location: login.php?status=registered");
                    exit();
                }
            }
        } catch(PDOException $e) {
            $message = "ERROR: Could not execute query. " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>User Registration</h1>
       
        <?php if(!empty($message)): ?>
            <div class="error-message"><?php echo $message; ?></div>
        <?php endif; ?>
       
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
           
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
           
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>
            </div>
           
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
           
            <div class="form-actions">
                <button type="submit">Register</button>
                <a href="login.php"><button type="button">Already Registered? Login</button></a>
            </div>
        </form>
    </div>
</body>
</html>
