<?php
include("db_connection.php");

// Fetch the count of books, rentals, and users
$book_count = $conn->query("SELECT COUNT(*) AS total FROM books")->fetch_assoc()['total'];
$rental_count = $conn->query("SELECT COUNT(*) AS total FROM rentals")->fetch_assoc()['total'];
$user_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
  <header class="header">
    <h1>Admin Dashboard</h1>
    <p>Welcome to the admin dashboard</p>
    <a href="login.php">Logout</a>
  </header>
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">Dashboard</a>

    <div class="menu-item">
        <a href="#" id="manage-books">Manage Books</a>
        <div class="submenu">
            <a href="add_book.php">Add Books</a>
            <a href="edit_book.php">Edit Books</a>
            <a href="remove_book.php">Remove Books</a>
        </div>
    </div>
    <a href="manage_rentals.php">Manage Rents</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_feedback.php">Feedback</a>
    <a href="report.php">Report</a>
  </div>
  <div class="container">
    <div class="dashboard-content">
      <div class="dashboard-cards">
        <div class="card">
          <h3>Total Books</h3>
          <p><?php echo $book_count; ?></p>
        </div>
        <div class="card">
          <h3>Total Rentals</h3>
          <p><?php echo $rental_count; ?></p>
        </div>
        <div class="card">
          <h3>Total Users</h3>
          <p><?php echo $user_count; ?></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
