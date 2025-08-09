<?php
include("db_connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Gallery</title>
  <link rel="stylesheet" href="sam1.css">
</head>
<body>

<header>
  <h1>Book Gallery</h1>
  <p>Explore our collection of books available for rent.</p>
  <form action="book-images.php" method="GET" class="search-form">
    <input type="text" name="search" placeholder="Search by title, author, or category" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button type="submit">Search</button>
  </form>
</header>



  <!-- Navigation -->
  <nav class="navbar">
    <ul>
      <li><a href="dashboard.php">Home</a></li>
      <li><a href="book-images.php" class="active">Books</a></li>
      <li><a href="book-renting.php">Rentals</a></li>
      <li><a href="rental_status.php">Rental Status</a></li>
      <li><a href="feedback.php">Feedbacks</a></li>
      <li><a href="welcome.php">Logout</a></li>
    </ul>
  </nav>

  <div class="container">
    <!-- Sidebar for Categories -->
    <aside class="sidebar">
      <h2>Categories</h2>
      <ul>
        <li><a href="book-images.php" class="<?= !isset($_GET['category']) ? 'active' : '' ?>">All Books</a></li>
        <?php
        $category_sql = "SELECT DISTINCT category FROM books";
        $category_result = $conn->query($category_sql);
        $selected_category = $_GET['category'] ?? ''; // Get the selected category

        while ($category = $category_result->fetch_assoc()) {
            $category_name = htmlspecialchars($category['category']);
            $is_active = ($selected_category === $category_name) ? 'active' : ''; // Check if it's the active category

            echo '<li><a href="book-images.php?category=' . urlencode($category_name) . '" class="' . $is_active . '">' . $category_name . '</a></li>';
        }
        ?>
      </ul>
    </aside>


    <!-- Main Book Gallery -->
    <section class="book-gallery">
      <?php
       // Fetch books data based on selected category and order alphabetically
       $search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $conn->real_escape_string($_GET['search']);
    $search_term = strtolower($search_term); // Convert to lowercase for case-insensitive search
    $search_query = " (LOWER(title) LIKE '%$search_term%' OR LOWER(author) LIKE '%$search_term%' OR LOWER(category) LIKE '%$search_term%')";
}

// Apply category filter if a category is selected
$category_filter = "";
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $selected_category = $conn->real_escape_string($_GET['category']);
    $category_filter = " category = '$selected_category'";
}

// Build the final WHERE clause properly
$where_clause = "";
if (!empty($category_filter) && !empty($search_query)) {
    $where_clause = " WHERE $category_filter AND $search_query";
} elseif (!empty($category_filter)) {
    $where_clause = " WHERE $category_filter";
} elseif (!empty($search_query)) {
    $where_clause = " WHERE $search_query";
}

// Final SQL query
$sql = "SELECT key_slug, title, author, image, category FROM books $where_clause ORDER BY title ASC";
$result = $conn->query($sql);

       if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
           echo '<div class="book">';
           echo '<a href="book-info.php?book=' . htmlspecialchars($row['key_slug']);
           if (isset($_GET['category'])) {
               echo '&category=' . urlencode($_GET['category']); // Preserve category filter
           }
           echo '">';
           echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
           echo '</a>';
           echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
           echo '</div>';
          }
        } else {
          echo '<p>No books available in this category.</p>';
        }
        $conn->close();
      ?>
    </section>
  </div>
</body>
</html>
