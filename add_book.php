<?php
include("db_connection.php");

$category_options = "";
$result = $conn->query("SELECT DISTINCT category FROM books");
while ($row = $result->fetch_assoc()) {
    $category_options .= "<option value='" . htmlspecialchars($row['category']) . "'>" . htmlspecialchars($row['category']) . "</option>";
}

// Handle book addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $key_slug = strtolower(trim($_POST['title']));
    $key_slug = preg_replace('/[^a-z0-9\s-]/', '', $key_slug);
    $key_slug = preg_replace('/\s+/', '-', $key_slug);
    $key_slug = $conn->real_escape_string($key_slug);
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $description = $conn->real_escape_string($_POST['description']);
    $category = $conn->real_escape_string($_POST['category']);

    // Handle Image Upload
   // Handle Image Upload
$image_name = "";
if (!empty($_FILES['image']['name'])) {
    $target_dir = "images/"; // Folder where images are stored
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_name = $target_file; // Save "images/filename.jpg" in database
    } else {
        echo "<script>alert('Image upload failed!');</script>";
        $image_name = ""; // Empty if upload fails
    }
}

// Insert into Database
$insert_sql = "INSERT INTO books (key_slug, title, author, description, category, image) 
               VALUES ('$key_slug', '$title', '$author', '$description', '$category', '$image_name')";

if ($conn->query($insert_sql)) {
    header("Location: add_book.php?success=1");
    exit();
} else {
    echo "<script>alert('Error adding book: " . $conn->error . "');</script>";
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Book</title>
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
  <h1>Add Book</h1>
  <p>Add new books</p>
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
    <?php if (isset($_GET['success'])): ?>
      <p class="success">Book added successfully!</p>
    <?php endif; ?>

    <section class="add-book-form">
      <h2>Add a New Book</h2>
      <form method="POST" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Author:</label>
        <input type="text" name="author" required>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <label>Category:</label>
        <select name="category" required>
            <option value="">Select Category</option>
            <?= $category_options; ?>
        </select>

        <label>Upload Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Add Book</button>
      </form>
    </section>
  </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
