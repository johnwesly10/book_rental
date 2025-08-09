<?php
include("db_connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Books</title>
  <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>

  <header class="header">
    <h1>Manage Books</h1>
    <p>Add new books or remove existing ones.</p>
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

    <!-- Main Content -->
    <div class="main-content">
      <h2>Welcome to Manage Books Section</h2>
      <p>Select an option from the menu to add or remove books.</p>
    </div>
  </div>

</body>
</html>

<?php $conn->close(); ?>
