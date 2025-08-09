<?php
include("db_connection.php");

// Handle book deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $conn->real_escape_string($_GET['delete_id']);
    $conn->query("DELETE FROM books WHERE book_id = '$delete_id'");
    header("Location: remove_book.php?deleted=1");
    exit();
}

// Fetch books categorized
$books_by_category = [];
$result = $conn->query("SELECT * FROM books ORDER BY category, title");
while ($row = $result->fetch_assoc()) {
    $books_by_category[$row['category']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Remove Books</title>
  <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>

<header class="header">
  <h1>Remove Books</h1>
  <p>Delete outdated or unavailable books from the system.</p>
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
  

  <div class="main-content">
    <?php if (isset($_GET['deleted'])): ?>
      <p class="success">Book removed successfully!</p>
    <?php endif; ?>
    
    <section class="book-list">
      <h2>Book List</h2>
      <?php foreach ($books_by_category as $category => $books): ?>
        <h3><?php echo htmlspecialchars($category); ?></h3>
        <table border="1">
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>Image</th>
            <th>Action</th>
          </tr>
          <?php foreach ($books as $book): ?>
            <tr>
              <td><?php echo htmlspecialchars($book['title']); ?></td>
              <td><?php echo htmlspecialchars($book['author']); ?></td>
              <td><?php echo htmlspecialchars($book['description']); ?></td>
              <td><img src="<?php echo htmlspecialchars($book['image']); ?>" width="50"></td>
              <td>
                <a href="?delete_id=<?php echo $book['book_id']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-reject">Remove</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      <?php endforeach; ?>
    </section>
  </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
