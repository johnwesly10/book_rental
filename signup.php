<?php
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize user input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Validate phone number (only digits, no spaces, no special characters)
    if (!preg_match('/^\d{10,15}$/', $phone_number)) {
        echo "<script>alert('Invalid phone number! Only digits allowed, max 15 digits.'); window.location.href='signup.php';</script>";
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.location.href='signup.php';</script>";
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username, email, or phone number already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ? OR phone_number = ?");
    $stmt->bind_param("ssi", $username, $email, $phone_number);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Username, email, or phone number already exists!'); window.location.href='signup.php';</script>";
        exit();
    }

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone_number, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $username, $email, $phone_number, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Page</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <img src="images/login.jpg" alt="Background Image" class="background-img">
  <div class="login-container">
    <form action="signup.php" method="POST" class="login-form">
      <h2>Signup</h2>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="tel" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter your password" required>
      </div>
      <button type="submit">Signup</button>
      <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>
