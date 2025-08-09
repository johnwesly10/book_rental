<?php
session_start(); // Start a session for authentication

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'book_rental');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch admin details
    $query = $conn->prepare("SELECT id, password_hash FROM admin WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $query->bind_result($id, $hashedPassword);

    if ($query->fetch()) {
        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Store admin details in session
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $username;

            // Redirect to the admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            header("Location: admin_login.php?error=invalid_password");
            exit();
        }
    } else {
        header("Location: admin_login.php?error=admin_not_found");
        exit();
    }

    $query->close();
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<img src="images/login.jpg" alt="Background Image" class="background-img">
  <div class="login-container">
    <form action="admin_login.php" method="POST" class="login-form">
      <h2>Admin Login</h2>
      <!-- <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?> -->
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
