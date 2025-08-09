<?php
include("db_connection.php");

// Get the book identifier from the query parameter
$bookId = $_GET['book'] ?? null;
$selectedCategory = $_GET['category'] ?? null; // Get category from URL

if ($bookId) {
    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT title, author, description, rent_amount, image FROM books WHERE key_slug = ?");
    $stmt->bind_param("s", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        // Redirect to a 404 or error page if book not found
        header("HTTP/1.0 404 Not Found");
        echo "<h1>Book not found</h1>";
        exit;
    }

    $stmt->close();
} else {
    // Redirect to a 404 or error page if bookId is not provided
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Book not found</h1>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - Book Info</title>
    <link rel="stylesheet" href="css/book-info.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($book['title']); ?></h1>
    </header>

    <section class="book-details">
        <div class="book-image">
            <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
        </div>
        <div class="book-info">
            <h2>Author: <?php echo htmlspecialchars($book['author']); ?></h2>
            <p><?php echo htmlspecialchars($book['description']); ?></p>
            <h4>RENT AMOUNT: ₹<?php echo htmlspecialchars($book['rent_amount']); ?></h4>
            <button onclick="location.href='book-renting.php?book_id=<?php echo urlencode($bookId); ?>'">Rent</button>
        </div>
    </section>

    <!-- Back to Gallery button with category preservation -->
    <nav>
        <button onclick="location.href='book-images.php<?php echo $selectedCategory ? '?category=' . urlencode($selectedCategory) : ''; ?>'">Back to Gallery</button>
    </nav>
</body>
</html>
