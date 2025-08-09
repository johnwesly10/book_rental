<?php
include("db_connection.php");

// Handle book update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_book'])) {
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);
    
    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "images/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_name = $target_file;
        } else {
            echo "<script>alert('Image upload failed!');</script>";
            $image_name = $_POST['existing_image'];
        }
    } else {
        $image_name = $_POST['existing_image'];
    }

    $update_sql = "UPDATE books SET title='$title', author='$author', description='$description', category='$category', image='$image_name' WHERE book_id='$book_id'";
    $conn->query($update_sql);
    header("Location: edit_book.php");
    exit();
}

// Fetch books
$books = $conn->query("SELECT * FROM books ORDER BY category, title");

// Fetch book details for editing if edit_id is set
$edit_book = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $conn->real_escape_string($_GET['edit_id']);
    $edit_book = $conn->query("SELECT * FROM books WHERE book_id='$edit_id'")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Books</title>
  <link rel="stylesheet" href="css/admin_dashboard.css">
  <style>
    /* Style for the category dropdown */
select[name="category"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 2px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    cursor: pointer;
    margin-bottom: 15px;
}

/* Style for category dropdown on hover */
select[name="category"]:hover {
    border-color: #007bff;
}

/* Style for category dropdown when selected */
select[name="category"]:focus {
    border-color: #007bff;
    outline: none;
}

/* Style for the file upload input */
input[type="file"] {
    display: block;
    width: 97%;
    padding: 10px;
    font-size: 16px;
    border: 2px solid #ccc;
    border-radius: 5px;
    background-color: #f8f9fa;
    cursor: pointer;
    margin-bottom: 15px;
}

/* Style for file input on hover */
input[type="file"]:hover {
    border-color: #007bff;
}

/* Success message */
.success {
    color: green;
    font-weight: bold;
    background: #d4edda;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 15px;
}

  </style>
</head>
<body>

<header class="header">
    <h1>Edit Books</h1>
    <p>Modify book details.</p>
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
        <?php if (!$edit_book): ?>
            <h2>Book List</h2>
            <table border="1">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <?php while ($book = $books->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['description']); ?></td>
                        <td><?php echo htmlspecialchars($book['category']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($book['image']); ?>" width="50"></td>
                        <td>
                            <a href="edit_book.php?edit_id=<?php echo $book['book_id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <section class="edit-book-form">
                <h2>Edit Book</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="book_id" value="<?php echo $edit_book['book_id']; ?>">
                    <label>Title:</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($edit_book['title']); ?>" required>
                    <label>Author:</label>
                    <input type="text" name="author" value="<?php echo htmlspecialchars($edit_book['author']); ?>" required>
                    <label>Description:</label>
                    <textarea name="description" required><?php echo htmlspecialchars($edit_book['description']); ?></textarea>
                    <label>Category:</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <?php
                        $categories = $conn->query("SELECT DISTINCT category FROM books");
                        while ($row = $categories->fetch_assoc()) {
                            $selected = ($row['category'] == $edit_book['category']) ? "selected" : "";
                            echo "<option value='" . htmlspecialchars($row['category']) . "' $selected>" . htmlspecialchars($row['category']) . "</option>";
                        }
                        ?>
                    </select>
                    <label>Upload New Image (leave blank to keep current):</label>
                    <input type="file" name="image" accept="image/*">
                    <img src="<?php echo htmlspecialchars($edit_book['image']); ?>" width="50">
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($edit_book['image']); ?>">
                    <button type="submit" name="update_book">Update Book</button>
                </form>
            </section>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>