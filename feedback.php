<?php
session_start(); 
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='login.html';</script>";
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback - Book Rental Shop</title>
  <style>
    /* General Styles */
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
      position: relative;
    }

    /* Header */
    header {
      text-align: center;
      background: linear-gradient(to right, #1e3c72, #2a5298);
      color: white;
      padding: 20px;
      width: 100%;
    }

    header h1 {
      margin: 0;
      font-size: 28px;
    }

    /* Navigation Bar */
    .navbar {
      background: #333;
      padding: 15px 0;
      text-align: center;
    }

    .navbar ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
    }

    .navbar li {
      margin: 0 15px;
    }

    .navbar a {
      text-decoration: none;
      color: white;
      padding: 10px 15px;
      transition: 0.3s ease;
    }

    .navbar a:hover,
    .navbar .active {
      background: #1abc9c;
      border-radius: 5px;
    }

    /* Background Image */
    .background-section {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      z-index: -1; /* Ensures it stays behind the content */
      overflow: hidden;
    }

    .background-section img {
      width: 100%;
      height: 100vh;
      object-fit: cover;
      opacity: 0.5;
    }

    /* Form Container */
    .container {
      position: relative;
      margin: 50px auto;
      width: 50%;
      padding: 20px 30px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      z-index: 1;
      text-align: center;
    }

    /* Form Styling */
    form {
      display: flex;
      flex-direction: column;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    input[readonly] {
      background: #e9ecef;
      cursor: not-allowed;
    }

    textarea {
      resize: none;
    }

    button {
      background: #2a5298;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      transition: 0.3s ease;
    }

    button:hover {
      background: #1abc9c;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .container {
        width: 80%;
      }

      .navbar ul {
        flex-direction: column;
      }

      .navbar li {
        margin: 5px 0;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Feedback</h1>
  </header>

  <!-- Navigation -->
  <nav class="navbar">
    <ul>
      <li><a href="dashboard.php">Home</a></li>
      <li><a href="book-images.php">Books</a></li>
      <li><a href="rental_status.php">Rental Status</a></li>
      <li><a href="feedback.php" class="active">Feedback</a></li>
      <li><a href="welcome.php">Logout</a></li>
    </ul>
  </nav>

  <section class="background-section">
    <img src="images/form.jpg" alt="Feedback Background">
  </section>

  <div class="container">
    <h2>We Value Your Feedback</h2>
    <p>Your feedback helps us improve our book rental service. Please take a moment to share your experience with us.</p>

    <h2>Submit Your Feedback</h2>
    <form action="submit_feedback.php" method="POST">
      <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
      <input type="text" name="mobile" placeholder="Your Mobile Number" required>

      <label for="rating">Rate Your Experience:</label>
      <select name="rating" id="rating" required>
        <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
        <option value="4">⭐⭐⭐⭐ - Very Good</option>
        <option value="3">⭐⭐⭐ - Good</option>
        <option value="2">⭐⭐ - Fair</option>
        <option value="1">⭐ - Poor</option>
      </select>

      <textarea name="message" placeholder="Share your thoughts..." rows="5" required></textarea>
      <button type="submit">Submit Feedback</button>
    </form>
  </div>
</body>
</html>
